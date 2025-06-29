<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}

include '../connect/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $diskon = $_POST['diskon'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO diskon (judul, diskon, tanggal_mulai, tanggal_selesai, deskripsi, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $judul, $diskon, $tanggal_mulai, $tanggal_selesai, $deskripsi, $status);
    $stmt->execute();

    header("Location: ../view/promo.php");
    exit;
}
?>
