<?php

include_once __DIR__."/get-available-tables-at-times-ungrouped.php";
include_once __DIR__."/../exceptions.php";
include_once __DIR__."/../connect.php";
include_once __DIR__."/../global.php";
include_once __DIR__."/../encryption.php";

// Greedy algorithm that sorts the tables from smallest # of seats to largest.
// Then it loops through the list of tables and compares each with it's neighbor multiple times
// until there are no outstanding guests left.
// For each loop the table that will have the least # of empty seats wins and is added
// to the $chosenTableIds list.
function findOptimalTableCombination(int $numGuests, array $tables){

    // Sort smallest seat tables to largest
    $ns = array_column($tables, 'num_seats');
    array_multisort($ns, SORT_ASC, $tables);

    $chosenTableIds = array();

    while($numGuests > 0){

        if (sizeof($tables) === 0){
            // Oh noes! We are out of tables!!
            throw new ReservationException("There are no more tables left and we still have ".$numGuests." guests left!", HAS_UNSEATED_GUESTS);
        }

        $candidateTb = null;

        for ($i=0; $i < sizeof($tables); $i++) { 
            $currTb = $tables[$i];

            if ($candidateTb === null){
                // On first iteration, just choose the first one as the candidate.
                // As the iterations continue, more optimal candidates will likely be found.
                $candidateTb = $currTb;
                continue;
            }

            if ($currTb["num_seats"] === $candidateTb["num_seats"]){
                // If the candidate table has the same # of seats, skip.
                continue;
            }

            $candGuestsStanding = max(0, $numGuests - $candidateTb["num_seats"]);
            $currGuestsStanding = max(0, $numGuests - $currTb["num_seats"]);

            if ($currGuestsStanding < $candGuestsStanding){
                // We found a table that will seat more guests
                $candidateTb = $currTb;
            }
        }
        $numGuests -= $candidateTb["num_seats"];
        array_push($chosenTableIds, $candidateTb["id"]);

        // Remove chosen table from tables array
        $tables = array_filter($tables, function($tb) use ($candidateTb){
            return $tb["id"] !== $candidateTb["id"];
        });
        $tables = array_values($tables); // Rebuild array indexes
    }
    return $chosenTableIds;
}

class ReservationOptions {
    public string $name;
    public string $email;
    public int $rest_id;
    public string $phone;
    public int $num_guests;
    public string $res_date;
    public string $res_time;
    public string $cc_number;
    public string $cc_cvv;
    public string $cc_exp_month;
    public string $cc_exp_year;
    public string $user_id;
}

function createReservation(ReservationOptions &$options){

    $times = getAvailTablesAtTimesUngrouped($options->res_date, $options->rest_id, $options->num_guests);
    $tables = array();
    foreach ($times as $item) {
        $time = $item[0];
        if ($time === $options->res_time){
            $tables = $item[1];
        }
    }

    if (sizeof($tables) <= 0){
        throw new ReservationException("No tables are available at ".$options->res_date, NO_TABLES_AVAILABLE);
    }

    $chosenTables = findOptimalTableCombination($options->num_guests, $tables);

    // Create reservation in db and return id from function
    global $conn;

    $conn->query("START TRANSACTION;");

    $stmt = $conn->prepare("INSERT INTO restaurant.reservation (name, phone_number, email, date, time, num_guests, user, rest_id, cc_number, cc_cvv, cc_month, cc_year, user) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);");

    $cc_number = $options->cc_number ? encrypt($ccEncrpytKey, $options->cc_number) : 'NULL';
    $cc_cvv = $options->cc_cvv ?? 'NULL';
    $cc_exp_month = $options->cc_exp_month ?? 'NULL';
    $cc_exp_year = $options->cc_exp_year ?? 'NULL';
    $username = $options->user_id ?? 'NULL';

    $stmt->bind_param(
        "sssssisisiiss",
        $options->name,
        $options->phone,
        $options->email,
        $options->res_date,
        $options->res_time,
        $options->num_guests,
        $options->userId,
        $options->rest_id,
        $cc_number,
        $cc_cvv,
        $cc_exp_month,
        $cc_exp_year,
        $username
    );

    $stmt->execute();

    $result = $conn->query("SELECT LAST_INSERT_ID();");

    $new_res_id = (int) $result->fetch_column(0);

    foreach ($chosenTables as $table_id) {
        $conn->query("INSERT INTO restaurant.reserved_table (resv_id, table_id) VALUES ($new_res_id, $table_id);");
    }

    $conn->query("COMMIT;");

    // Return @res_id from SQL
    return $new_res_id;
}

?>