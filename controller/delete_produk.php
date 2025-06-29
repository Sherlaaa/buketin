<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}
include '../connect/database.php';

$id = $_GET['id'];

// Ambil nama gambar berdasarkan ID
$query = $conn->prepare("SELECT gambar FROM produk WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();

if ($data && !empty($data['gambar'])) {
    $gambar_path = '../uploads/' . $data['gambar'];
    if (file_exists($gambar_path)) {
        unlink($gambar_path); // Hapus file gambar
    }
}

// Hapus data dari database
$stmt = $conn->prepare("DELETE FROM produk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../view/produk.php");
exit;
?>
