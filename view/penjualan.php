<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}
include '../connect/database.php';

// Ambil data produk dan konsumen
$produk = $conn->query("SELECT * FROM produk");
$pelanggan = $conn->query("SELECT * FROM konsumen");

// Ambil data penjualan lengkap dengan join
$penjualan = $conn->query("
    SELECT pj.*, 
           pr.nama AS nama_produk, 
           pr.harga, 
           kn.nama AS nama_konsumen, 
           kn.status AS status_konsumen, 
           dsk.diskon AS persen_diskon, 
           dsk.judul AS judul_diskon
    FROM penjualan pj
    JOIN produk pr ON pj.id_produk = pr.id
    JOIN konsumen kn ON pj.id_pelanggan = kn.id
    LEFT JOIN diskon dsk ON pj.id_diskon = dsk.id
    ORDER BY pj.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penjualan</title>
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
        <div class="container">

            <!-- FORM TAMBAH PENJUALAN -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Penjualan</h5>
                </div>
                <div class="card-body">
                    <form action="../controller/add_penjualan.php" method="POST" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Produk</label>
                            <select name="id_produk" class="form-select" required>
                                <option value="">-- Pilih Produk --</option>
                                <?php while($p = $produk->fetch_assoc()): ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= $p['nama'] ?> (Rp <?= number_format($p['harga'], 0, ',', '.') ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Konsumen</label>
                            <select name="id_pelanggan" class="form-select" required>
                                <option value="">-- Pilih Konsumen --</option>
                                <?php while($pl = $pelanggan->fetch_assoc()): ?>
                                    <option value="<?= $pl['id'] ?>">
                                        <?= $pl['nama'] ?> (<?= ucfirst($pl['status']) ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- LIST PENJUALAN -->
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-list-ul"></i> Data Penjualan</h4>
            </div>

            <?php if ($penjualan->num_rows > 0): ?>
                <?php while($row = $penjualan->fetch_assoc()): ?>
                <div class="card card-penjualan mb-3 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1"><?= htmlspecialchars($row['nama_produk']) ?> <span class="badge bg-info">x<?= $row['jumlah'] ?></span></h5>
                            <p class="mb-1"><strong>Pelanggan:</strong> <?= $row['nama_konsumen'] ?> <span class="badge bg-secondary"><?= ucfirst($row['status_konsumen']) ?></span></p>
                            <p class="mb-1"><strong>Tanggal:</strong> <?= $row['tanggal'] ?></p>
                            <p class="mb-1"><strong>Diskon:</strong> <?= $row['judul_diskon'] ? $row['judul_diskon'] . " ({$row['persen_diskon']}%)" : '-' ?></p>
                            <p class="mb-0"><strong>Total Harga:</strong> <span class="text-success">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></span></p>
                        </div>
                        <div>
                            <a href="../controller/delete_penjualan.php?id=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-warning text-center">Belum ada data penjualan.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
