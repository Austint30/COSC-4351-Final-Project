<?php
    include '../../include/reservation/get-available-tables-at-times-ungrouped.php';

    $HOUR_BEGIN = 6; // 6 AM (opening time)
    $HOUR_END = 20; // 8 PM (closing time)

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON);

    $date   = $input->date;
    $rest_id = $input->rest_id;
    $num_guests = $input->num_guests ?? null;

    $availableTimes = getAvailTablesAtTimesUngrouped($date, $rest_id, (int) $num_guests);

    header("Content-Type: application/json; charset=utf-8");

    echo json_encode($availableTimes);

?>