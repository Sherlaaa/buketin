<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}
include '../connect/database.php';

$member = $conn->query("SELECT COUNT(*) AS total FROM konsumen WHERE status = 'member'")->fetch_assoc()['total'];
$biasa  = $conn->query("SELECT COUNT(*) AS total FROM konsumen WHERE status = 'biasa'")->fetch_assoc()['total'];
$jml_produk = $conn->query("SELECT COUNT(*) AS total FROM produk")->fetch_assoc()['total'];
$jml_promo = $conn->query("SELECT COUNT(*) AS total FROM diskon WHERE tanggal_mulai <= CURDATE() AND tanggal_selesai >= CURDATE()")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div class="container-fluid mt-4">
            <h2 class="mb-4 fw-semibold">Dashboard</h2>

            <!-- Ringkasan -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card info-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Konsumen Member</h6>
                                <h4 class="fw-bold"><?= $member ?></h4>
                            </div>
                            <i class="bi bi-person-badge-fill info-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card info-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Konsumen Biasa</h6>
                                <h4 class="fw-bold"><?= $biasa ?></h4>
                            </div>
                            <i class="bi bi-people-fill info-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card info-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Jumlah Produk</h6>
                                <h4 class="fw-bold"><?= $jml_produk ?></h4>
                            </div>
                            <i class="bi bi-box-seam info-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card info-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1">Promo Aktif</h6>
                                <h4 class="fw-bold"><?= $jml_promo ?></h4>
                            </div>
                            <i class="bi bi-tag-fill info-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm rounded-4 mb-4">
                        <div class="card-header">
                            Statistik Konsumen (Pie)
                        </div>
                        <div class="card-body">
                            <canvas id="konsumenChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-success text-white rounded-top-4">
                            Statistik Data Keseluruhan (Bar)
                        </div>
                        <div class="card-body">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../layout/footer.php'; ?>
</div>

<script>
    // Pie Chart Konsumen
    const pieCtx = document.getElementById('konsumenChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Member', 'Biasa'],
            datasets: [{
                data: [<?= $member ?>, <?= $biasa ?>],
                backgroundColor: ['#f06292', '#64b5f6']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Member', 'Biasa', 'Produk', 'Promo'],
            datasets: [{
                label: 'Jumlah',
                data: [<?= $member ?>, <?= $biasa ?>, <?= $jml_produk ?>, <?= $jml_promo ?>],
                backgroundColor: ['#f06292', '#64b5f6', '#ffd54f', '#e57373']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

</body>
</html>
