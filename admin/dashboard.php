<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, <?php echo $_SESSION['nama']; ?></p>
        <div class="list-group">
            <a href="manage_alumni.php" class="list-group-item list-group-item-action">Manajemen Alumni</a>
            <a href="#" class="list-group-item list-group-item-action">Validasi Data (TODO)</a>
            <a href="#" class="list-group-item list-group-item-action">Laporan Tracer Study (TODO)</a>
            <a href="../views/map.php" class="list-group-item list-group-item-action">Lihat Peta</a>
            <a href="../controllers/AuthController.php?action=logout" class="list-group-item list-group-item-action list-group-item-danger">Logout</a>
        </div>
    </div>
</body>
</html>