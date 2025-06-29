<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}

include '../connect/database.php';

$id = $_GET['id'] ?? null;

// Validasi ID
if (!$id || !is_numeric($id)) {
    echo "<script>alert('ID tidak valid.'); window.location='../view/konsumen.php';</script>";
    exit;
}

// Cek apakah konsumen punya relasi di tabel penjualan
$cekRelasi = $conn->prepare("SELECT COUNT(*) as total FROM penjualan WHERE id_pelanggan = ?");
$cekRelasi->bind_param("i", $id);
$cekRelasi->execute();
$relasiResult = $cekRelasi->get_result()->fetch_assoc();
$cekRelasi->close();

if ($relasiResult['total'] > 0) {
    echo "<script>alert('Konsumen tidak dapat dihapus karena masih memiliki riwayat penjualan.'); window.location='../view/konsumen.php';</script>";
    exit;
}

// Hapus data konsumen
$stmt = $conn->prepare("DELETE FROM konsumen WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Data konsumen berhasil dihapus.'); window.location='../view/konsumen.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data konsumen.'); window.location='../view/konsumen.php';</script>";
}

$stmt->close();
$conn->close();
?>
