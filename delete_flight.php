<?php
session_start();
require "config.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM flights WHERE id=$id");
header("Location: dashboard.php");
exit;
