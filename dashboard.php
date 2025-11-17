<?php
session_start();
require "config.php";
$isLoggedIn = isset($_SESSION['user_id']);
$role = $isLoggedIn ? $_SESSION['role'] : null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">Airline Ticket System</span>
        <?php if($isLoggedIn): ?>
            <a href="logout.php" class="btn btn-light">Logout</a>
        <?php else: ?>
            <a href="index.php" class="btn btn-light">Login</a>
        <?php endif; ?>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-4">Dashboard</h3>

    <?php if (!$isLoggedIn): ?>
        <div class="alert alert-warning">Silakan login untuk dapat memesan tiket atau mengelola data penerbangan.</div>
    <?php endif; ?>

    <?php if ($isLoggedIn && $role == "admin"): ?>
        <a href="add_flight.php" class="btn btn-success mb-3">Tambah Penerbangan</a>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>Maskapai</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Waktu Berangkat</th>
                <th>Waktu Tiba</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM flights");
        while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['airline'] ?></td>
                <td><?= $row['origin'] ?></td>
                <td><?= $row['destination'] ?></td>
                <td><?= date("H:i", strtotime($row['departure_time'])) ?></td>
                <td><?= date("H:i", strtotime($row['arrival_time'])) ?></td>
                <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                <td>
                    <?php if ($isLoggedIn && $role == "admin"): ?>
                        <a href="edit_flight.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_flight.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>

                    <?php elseif ($isLoggedIn && $role == "user"): ?>
                        <a href="booking_form.php?flight_id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Pesan</a>

                    <?php else: ?>
                        <span class="text-muted">Login untuk pesan</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

</div>

<?php if ($isLoggedIn && $role == "user"): ?>
        <div class="container mt-4">

            <h4 class="mb-4">Riwayat Pemesanan Tiket</h4>

            <?php
            $uid = $_SESSION['user_id'];
            $queryBooking = mysqli_query($conn, 
                "SELECT b.*, f.airline, f.origin, f.destination, f.price
                 FROM bookings b
                 JOIN flights f ON b.flight_id = f.id
                 WHERE b.user_id = $uid
                 ORDER BY b.id DESC"
            );
            ?>

            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Maskapai</th>
                        <th>Rute</th>
                        <th>Nama Penumpang</th>
                        <th>No Identitas</th>
                        <th>Harga</th>
                        <th>Tanggal Pesan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($b = mysqli_fetch_assoc($queryBooking)): ?>
                        <tr>
                            <td><?= $b['airline'] ?></td>
                            <td><?= $b['origin'] ?> → <?= $b['destination'] ?></td>
                            <td><?= $b['passenger_name'] ?></td>
                            <td><?= $b['passenger_id'] ?></td>
                            <td>Rp <?= number_format($b['price'], 0, ',', '.') ?></td>
                            <td><?= $b['booking_date'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
    </div>

<?php endif; ?>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
