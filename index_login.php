<?php
session_start();
require "config.php";

// proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="card p-4 shadow" style="width: 380px;">
        <h3 class="text-center mb-3">Login Sistem Tiket</h3>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="text-center mt-3">
            <a href="register.php">Belum punya akun? Register</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
