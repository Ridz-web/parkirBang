<?php
session_start();
include "../config/database.php";

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $db->prepare("SELECT * FROM users WHERE username=?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && $user['password'] === md5($password)) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } elseif ($user['role'] == 'petugas') {
        header("Location: ../petugas/dashboard.php");
    } else {
        header("Location: ../owner/laporan.php");
    }
} else {
    header("Location: ../index.php?error=login_failed");
}