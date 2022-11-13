<?php
    include '../../include/connect.php';

    $HOUR_BEGIN = 6; // 6 AM (opening time)
    $HOUR_END = 20; // 8 PM (closing time)

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON);

    $date   = $input->date;
    $rest_id = $input->rest_id;
    $num_guests = $input->num_guests ?? null;

    $parsedDate = DateTime::createFromFormat("Y-m-d", $date);

    if ($parsedDate->format('Y-m-d') < (new DateTime("now"))->format('Y-m-d')){
        echo json_encode(array());
        exit;
    }

    $time = new DateTime();
    $time->setTime($HOUR_BEGIN, 0, 0, 0);

    $availableTimes = array();

    while(((int) (clone $time)->add(new DateInterval("PT59M"))->format('H')) < $HOUR_END){

        $resvTime = $time->format("H:i");
        $timeOffset = (clone $time)->sub(new DateInterval("PT2H"))->format("H:i"); // 2 hours before

        // Get the count of each table group (by num_seats) if it is not already reserved within two hours of the chosen time
        $stmt = $conn->prepare(
            "SELECT num_seats, COUNT(num_seats) as num_tables FROM restaurant.r_table
            WHERE r_table.rest_id = ? AND r_table.id NOT IN (
                SELECT table_id FROM restaurant.reserved_table
                INNER JOIN restaurant.reservation ON resv_id = reservation.id AND reservation.date = ? AND ( reservation.time <= ? AND reservation.time > ?)
            )
            GROUP BY num_seats;");

        $stmt->bind_param("isss", $rest_id, $date, $resvTime, $timeOffset);

        $stmt->execute();

        $result = $stmt->get_result();

        $result_array = array();
        
        $total_seats = 0;
        while($row = $result->fetch_assoc()){
            $total_seats += ((int) $row["num_seats"]) * ((int) $row["num_tables"]);
            array_push($result_array, $row);
        }

        // Not enough table seats for this number of guests
        if ($num_guests === null || $total_seats >= $num_guests){
            array_push($availableTimes, array($time->format("H:i"), $result_array));
        }

        $time->add(new DateInterval("PT30M")); // Add 30 minutes
    }

    

    header("Content-Type: application/json; charset=utf-8");

    echo json_encode($availableTimes);

?>