<?php
session_start();
include '../connect/database.php';

$id_produk    = $_POST['id_produk'];
$id_pelanggan = $_POST['id_pelanggan'];
$jumlah       = $_POST['jumlah'];
$tanggal      = $_POST['tanggal'];

// Ambil harga produk
$stmt = $conn->prepare("SELECT harga FROM produk WHERE id = ?");
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$produk = $stmt->get_result()->fetch_assoc();
$harga = $produk['harga'];

// Ambil status konsumen
$stmt = $conn->prepare("SELECT status FROM konsumen WHERE id = ?");
$stmt->bind_param("i", $id_pelanggan);
$stmt->execute();
$konsumen = $stmt->get_result()->fetch_assoc();
$status_konsumen = $konsumen['status'];

// Ambil diskon sesuai status dan tanggal aktif
$stmt = $conn->prepare("SELECT id, diskon FROM diskon WHERE status = ? AND tanggal_mulai <= CURDATE() AND tanggal_selesai >= CURDATE() ORDER BY diskon DESC LIMIT 1");
$stmt->bind_param("s", $status_konsumen);
$stmt->execute();
$diskon_data = $stmt->get_result()->fetch_assoc();

$diskon_id     = $diskon_data ? $diskon_data['id'] : null;
$diskon_persen = $diskon_data ? $diskon_data['diskon'] : 0;

// Hitung total harga
$subtotal     = $harga * $jumlah;
$diskon_total = ($diskon_persen / 100) * $subtotal;
$total_harga  = $subtotal - $diskon_total;

// Simpan penjualan
if ($diskon_id) {
    $stmt = $conn->prepare("INSERT INTO penjualan (id_produk, id_pelanggan, tanggal, jumlah, total_harga, id_diskon) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisidi", $id_produk, $id_pelanggan, $tanggal, $jumlah, $total_harga, $diskon_id);
} else {
    $stmt = $conn->prepare("INSERT INTO penjualan (id_produk, id_pelanggan, tanggal, jumlah, total_harga) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisid", $id_produk, $id_pelanggan, $tanggal, $jumlah, $total_harga);
}
$stmt->execute();

header("Location: ../view/penjualan.php");
exit;
?>
