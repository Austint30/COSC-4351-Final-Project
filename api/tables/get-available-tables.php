<?php
    include '../../include/connect.php';

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON);

    $date   = $input->date;
    $time   = $input->time;
    $rest_id = $input->rest_id;

    $parsedTime = DateTime::createFromFormat("H:i", $time);

    $resvTime = $parsedTime->format("H:i");
    $timeOffset = $parsedTime->sub(new DateInterval("PT2H"))->format("H:i"); // 2 hours before

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

    while($row = $result->fetch_assoc()){
        array_push($result_array, $row);
    }

    header("Content-Type: application/json; charset=utf-8");

    echo json_encode($result_array);

?>