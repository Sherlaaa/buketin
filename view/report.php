<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}
include '../connect/database.php';

$penjualan = $conn->query("
    SELECT 
        p.id,
        pr.nama AS nama_produk,
        pr.warna,
        pr.harga,
        kn.nama AS nama_pelanggan,
        p.jumlah,
        p.tanggal,
        p.total_harga
    FROM penjualan p
    JOIN produk pr ON p.id_produk = pr.id
    JOIN konsumen kn ON p.id_pelanggan = kn.id
    ORDER BY p.tanggal DESC
");

$totalPendapatan = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            height: 100%;
            overflow: hidden;
            background-color: #fff0f5; /* pastel blush */
            color: #4a4a4a;
            font-family: 'Segoe UI', sans-serif;
        }

        .main-content {
            margin-left: 250px;
            padding-top: 70px;
            padding-bottom: 60px;
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .info-card {
            background-color: #ffffff;
            border-left: 5px solid #f06292;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .info-icon {
            font-size: 1.75rem;
            color: #f06292;
        }

        .card-header {
            background-color: #f06292 !important;
            color: white !important;
            font-weight: 600;
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
        }

        h2 {
            color: #c2185b;
        }

        canvas {
            max-height: 250px;
        }
    </style>
</head>
<body>

<?php include '../layout/navbar.php'; ?>

<div class="main-content">
    <?php include '../layout/header.php'; ?>

    <div class="content-wrapper">
        <div class="container mt-4">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center rounded-top">
                    <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Laporan Penjualan</h5>
                    <a href="../controller/export_excel.php" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel"></i> Export ke Excel
                    </a>
                </div>
                <div class="card-body">
                    <p class="mb-4 text-muted">Berikut adalah laporan transaksi penjualan produk selama periode berjalan.</p>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-white text-center">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Produk</th>
                                    <th>Warna</th>
                                    <th>Harga Satuan</th>
                                    <th>Pelanggan</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $penjualan->fetch_assoc()): ?>
                                    <?php $totalPendapatan += $row['total_harga']; ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                        <td><?= htmlspecialchars($row['warna']) ?></td>
                                        <td class="text-end">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                        <td class="text-center"><?= $row['jumlah'] ?></td>
                                        <td class="text-end fw-semibold">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-success fw-bold text-end">
                                    <td colspan="6">Total Pendapatan</td>
                                    <td>Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div> <!-- end card -->
        </div>
    </div>

    <?php include '../layout/footer.php'; ?>
</div>
</body>
</html>
