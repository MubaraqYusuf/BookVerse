<?php
date_default_timezone_set("Europe/Vilnius");   // Set PHP timezone

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "library_db";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

// Make MySQL use the SAME timezone as PHP
$conn->query("SET time_zone = '+02:00'");
?>
