<?php
session_start();
include_once '../config/database.php';
include_once '../models/User.php';
include_once '../models/Alumni.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$alumni = new Alumni($db);

if(isset($_POST['register'])) {
    $user->nama = $_POST['nama'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->role = 'alumni';

    if($user->emailExists()){
        $_SESSION['error'] = "Email sudah terdaftar!";
        header("Location: ../views/auth/register.php");
        exit();
    }

    if($user->create()){
        // Get the created user ID (Need a method for this or just query)
        // For simplicity, re-query or use lastInsertId if implemented in DB class.
        // Assuming user needs to fill alumni profile later or create placeholder now.
        // Let's just create user and redirect to login.
        $_SESSION['success'] = "Registrasi berhasil. Silakan login.";
        header("Location: ../views/auth/login.php");
    } else {
        $_SESSION['error'] = "Gagal registrasi.";
        header("Location: ../views/auth/register.php");
    }
}

if(isset($_POST['login'])) {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    $stmt = $user->login();
    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($user->password, $row['password'])) {
            $_SESSION['user_id'] = $row['id_user'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = $row['role'];

            if($row['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../alumni/dashboard.php");
            }
        } else {
            $_SESSION['error'] = "Password salah.";
            header("Location: ../views/auth/login.php");
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan.";
        header("Location: ../views/auth/login.php");
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: ../views/auth/login.php");
}
?>