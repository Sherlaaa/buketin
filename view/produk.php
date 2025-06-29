<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}
include '../connect/database.php';
$result = $conn->query("SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Produk</title>
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

        .table img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
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
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Data Produk</h5>
                    <a href="../controller/add_produk.php" class="btn btn-success btn-sm add-button">
                        <i class="bi bi-plus-circle"></i> Tambah Produk
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="text-center">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Warna</th>
                                    <th>Harga</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if (!empty($row['gambar']) && file_exists("../uploads/" . $row['gambar'])): ?>
                                            <img src="../uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar Produk">
                                        <?php else: ?>
                                            <img src="../assets/no-image.png" alt="Tidak ada gambar">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['warna']) ?></span></td>
                                    <td><strong>Rp <?= number_format($row['harga'], 0, ',', '.') ?></strong></td>
                                    <td class="text-center">
                                        <a href="../controller/edit_produk.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="../controller/delete_produk.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus produk ini?')" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php if ($result->num_rows === 0): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data produk.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../layout/footer.php'; ?>
</div>

</body>
</html>
