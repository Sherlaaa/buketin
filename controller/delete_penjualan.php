<?php
session_start();
include '../connect/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID penjualan tidak valid!";
    exit;
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM penjualan WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../view/penjualan.php");
    exit;
} else {
    echo "Gagal menghapus data.";
}

$stmt->close();
$conn->close();
