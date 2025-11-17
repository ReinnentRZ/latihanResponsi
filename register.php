<?php
require "config.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = "user";

    $insert = mysqli_query($conn, "INSERT INTO users (username, password, role)
                                   VALUES ('$username', '$password', '$role')");

    if ($insert) {
        header("Location: index_login.php?msg=registered");
        exit;
    } else {
        $error = "Registrasi gagal — username mungkin sudah dipakai";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="card p-4 shadow" style="width: 380px;">
        <h3 class="text-center mb-3">Register Akun</h3>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button type="submit" name="register" class="btn btn-success w-100">Register</button>
        </form>

        <div class="text-center mt-3">
            <a href="index.php">Sudah punya akun? Login</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
