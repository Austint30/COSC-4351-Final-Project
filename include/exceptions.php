<?php

class InvalidMethodException extends Exception {}

define("HAS_UNSEATED_GUESTS", 0);
define("NO_TABLES_AVAILABLE", 1);

class ReservationException extends Exception {
    public function __construct($message, $code, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>