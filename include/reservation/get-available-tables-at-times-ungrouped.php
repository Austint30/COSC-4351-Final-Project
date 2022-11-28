<?php
include_once __DIR__.'/../connect.php';
include_once __DIR__.'/../global.php';

$HOUR_BEGIN = 6; // 6 AM (opening time)
$HOUR_END = 20; // 8 PM (closing time)

function getAvailTablesAtTimesUngrouped(string $date, string $rest_id, int $num_guests){
    global $HOUR_BEGIN;
    global $HOUR_END;
    global $conn;
    global $highTrafficThreshold;

    $parsedDate = DateTime::createFromFormat("Y-m-d", $date);

    if ($parsedDate->format('Y-m-d') < (new DateTime("now"))->format('Y-m-d')){
        return array();
    }

    $month = intval($parsedDate->format("m"));
    $day = intval($parsedDate->format("d"));

    // Is this day a special day (higher traffic than normal)
    $res = $conn->query("SELECT description FROM restaurant.special_days WHERE month=$month AND day=$day");
    $special_day_desc = null;
    $row = $res->fetch_assoc();
    if ($row){
        $special_day_desc = $row["description"];
    }

    $time = new DateTime();

    $today = new DateTime();

    $time->setTime($HOUR_BEGIN, 0, 0, 0);

    $availableTimes = array();

    while(intval($time->format('H')) < $HOUR_END){

        // If the date selected is today, skip listing of times before the current time
        if ($parsedDate->format("Y-m-d") == $today->format("Y-m-d")){
            // Date selected is today.
            
            if ($today->format('H:i') > (clone $time)->sub(new DateInterval("PT30M"))->format('H:i')){
                $time->add(new DateInterval("PT30M")); // Add 30 minutes
                continue;
            }
        }

        $resvTime = $time->format("H:i");
        $timeOffset = (clone $time)->sub(new DateInterval("PT2H"))->format("H:i"); // 2 hours before

        // Get the count of each table group (by num_seats) if it is not already reserved within two hours of the chosen time
        $stmt = $conn->prepare(
            "SELECT id, num_seats FROM restaurant.r_table
            WHERE r_table.rest_id = ? AND r_table.id NOT IN (
                SELECT table_id FROM restaurant.reserved_table
                INNER JOIN restaurant.reservation ON resv_id = reservation.id AND reservation.date = ? AND ( reservation.time <= ? AND reservation.time > ?)
            )");

        $stmt->bind_param("isss", $rest_id, $date, $resvTime, $timeOffset);

        $stmt->execute();

        $result = $stmt->get_result();

        $result_array = array();
        
        $total_seats = 0;
        while($row = $result->fetch_assoc()){
            $total_seats += (int) $row["num_seats"];
            array_push($result_array, $row);
        }

        $total_tb_result = $conn->query("SELECT COUNT(id) FROM restaurant.r_table");

        $total_tb = $total_tb_result->fetch_array()[0];

        $perc_available = sizeof($result_array) / $total_tb;

        // Not enough table seats for this number of guests
        if ($num_guests === null || $total_seats >= $num_guests){
            array_push(
                $availableTimes,
                array(
                    $time->format("H:i"),
                    $result_array,
                    $perc_available,
                    $special_day_desc ? true : ($perc_available < $highTrafficThreshold), // Is high traffic
                    $special_day_desc
                ));
        }

        $time->add(new DateInterval("PT30M")); // Add 30 minutes
    }

    return $availableTimes;
}

?>