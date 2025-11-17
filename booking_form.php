<?php
session_start();
require "config.php";

// hanya user yang login boleh booking
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit;
}

// cek flight id
if (!isset($_GET['flight_id'])) {
    header("Location: dashboard.php?msg=error");
    exit;
}

$flight_id = $_GET['flight_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">Form Booking Tiket</span>
        <a href="dashboard.php" class="btn btn-light">Kembali</a>
    </div>
</nav>

<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow p-4" style="width: 450px;">
        <h4 class="text-center mb-3">Isi Data Penumpang</h4>

        <form method="POST" action="booking.php">
            <input type="hidden" name="flight_id" value="<?= $flight_id ?>">

            <div class="mb-3">
                <label class="form-label">Nama Penumpang</label>
                <input type="text" name="passenger_name" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Identitas (KTP / ID)</label>
                <input type="text" name="passenger_id" class="form-control" placeholder="Masukkan nomor identitas" required>
            </div>

            <button type="submit" name="book" class="btn btn-success w-100">Konfirmasi Pemesanan</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
