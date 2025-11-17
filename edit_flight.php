<?php
session_start();
require "config.php";

// hanya admin yang boleh edit flight
if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM flights WHERE id=$id"));

if (isset($_POST['update'])) {
    mysqli_query($conn, "UPDATE flights SET 
        airline='{$_POST['airline']}',
        origin='{$_POST['origin']}',
        destination='{$_POST['destination']}',
        departure_time='{$_POST['departure_time']}',
        arrival_time='{$_POST['arrival_time']}',
        price='{$_POST['price']}'
        WHERE id=$id");

    header("Location: dashboard.php?msg=updated");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Penerbangan</title>
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
        <h3 class="text-center mb-4">Edit Data Penerbangan</h3>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Maskapai</label>
                <input type="text" name="airline" class="form-control" value="<?= $data['airline'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Asal Keberangkatan</label>
                <input type="text" name="origin" class="form-control" value="<?= $data['origin'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tujuan</label>
                <input type="text" name="destination" class="form-control" value="<?= $data['destination'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Waktu Berangkat</label>
                <input type="datetime-local" name="departure_time" class="form-control" value="<?= str_replace(' ', 'T', $data['departure_time']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Waktu Tiba</label>
                <input type="datetime-local" name="arrival_time" class="form-control" value="<?= str_replace(' ', 'T', $data['arrival_time']) ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" value="<?= $data['price'] ?>" required>
            </div>

            <button type="submit" name="update" class="btn btn-warning w-100">Update Data</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
