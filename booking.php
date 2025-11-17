<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit;
}

if (!isset($_POST['flight_id']) || !isset($_POST['passenger_name']) || !isset($_POST['passenger_id'])) {
    header("Location: dashboard.php?msg=error");
    exit;
}

$flight_id = $_POST['flight_id'];
$user_id = $_SESSION['user_id'];
$name = $_POST['passenger_name'];
$pid = $_POST['passenger_id'];

mysqli_query($conn, "INSERT INTO bookings (user_id, flight_id, passenger_name, passenger_id) VALUES ('$user_id', '$flight_id', '$name', '$pid')");

header("Location: dashboard.php?msg=book_success");
exit;
