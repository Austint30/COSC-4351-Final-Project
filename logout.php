<?php

session_start();
session_unset(); // Clear session

header("Location: /?successmsg=You are logged out");
?>