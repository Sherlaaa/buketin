<?php
include '../connect/database.php';

header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

// Query sesuai struktur yang kamu gunakan
$penjualan = $conn->query("
    SELECT 
        p.id,
        pr.nama AS nama_produk,
        pr.warna,
        pr.harga,
        k.nama AS nama_konsumen,
        p.jumlah,
        p.tanggal,
        p.total_harga
    FROM penjualan p
    JOIN produk pr ON p.id_produk = pr.id
    JOIN konsumen k ON p.id_pelanggan = k.id
    ORDER BY p.tanggal DESC
");

$totalPendapatan = 0;
?>

<table border="1">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama Produk</th>
            <th>Warna</th>
            <th>Harga Satuan</th>
            <th>Nama Konsumen</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $penjualan->fetch_assoc()): ?>
            <?php $totalPendapatan += $row['total_harga']; ?>
            <tr>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['nama_produk'] ?></td>
                <td><?= $row['warna'] ?></td>
                <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= $row['nama_konsumen'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= number_format($row['total_harga'], 0, ',', '.') ?></td>
            </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="6"><strong>Total Pendapatan</strong></td>
            <td><strong><?= number_format($totalPendapatan, 0, ',', '.') ?></strong></td>
        </tr>
    </tbody>
</table>
