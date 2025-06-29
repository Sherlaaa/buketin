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
    <title>Data Katalog</title>
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

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .badge-warna {
            background-color: #f06292;
            color: white;
            font-size: 0.85rem;
            padding: 0.4em 0.6em;
            border-radius: 0.5rem;
            display: inline-block;
            width: fit-content;
        }
    </style>
</head>
<body>

<?php include '../layout/navbar.php'; ?>

<div class="main-content">
    <?php include '../layout/header.php'; ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-grid-3x3-gap-fill"></i> Katalog Produk</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <?php if (!empty($row['gambar'])): ?>
                                        <img src="../uploads/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama']) ?>">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
                                    <?php endif; ?>
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <h5 class="card-title"><?= htmlspecialchars($row['nama']) ?></h5>
                                        <span class="badge badge-warna mb-2">Warna: <?= htmlspecialchars($row['warna']) ?></span>
                                        <p class="price-tag fw-bold mb-0">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php if ($result->num_rows === 0): ?>
                            <div class="col-12 text-center text-muted">Belum ada data produk.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../layout/footer.php'; ?>
</div>

</body>
</html>
