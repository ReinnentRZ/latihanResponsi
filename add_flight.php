<?php
session_start();
require "config.php";

// access control: hanya admin boleh
if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

// proses simpan data flight
if (isset($_POST['save'])) {
    $airline = $_POST['airline'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $departure = $_POST['departure_time'];
    $arrival = $_POST['arrival_time'];
    $price = $_POST['price'];

    mysqli_query($conn, "INSERT INTO flights (airline, origin, destination, departure_time, arrival_time, price)
                         VALUES ('$airline', '$origin', '$destination', '$departure', '$arrival', '$price')");
    header("Location: dashboard.php?msg=added");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penerbangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">Airline Ticket System</span>
        <a href="dashboard.php" class="btn btn-light">Kembali</a>
    </div>
</nav>

<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow p-4" style="width: 550px;">
        <h3 class="text-center mb-4">Tambah Data Penerbangan</h3>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Maskapai</label>
                <input type="text" name="airline" class="form-control" placeholder="Contoh: Garuda Indonesia" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Asal Keberangkatan</label>
                <input type="text" name="origin" class="form-control" placeholder="Contoh: Jakarta" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tujuan</label>
                <input type="text" name="destination" class="form-control" placeholder="Contoh: Bali" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Waktu Berangkat</label>
                <input type="datetime-local" name="departure_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Waktu Tiba</label>
                <input type="datetime-local" name="arrival_time" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" placeholder="Contoh: 1500000" required>
            </div>

            <button type="submit" name="save" class="btn btn-success w-100">Simpan Data</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
