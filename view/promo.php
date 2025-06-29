<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}
include '../connect/database.php';

$result = $conn->query("SELECT * FROM diskon ORDER BY tanggal_mulai DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Promo</title>
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

            <!-- Form Tambah Promo -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Promo</h5>
                </div>
                <div class="card-body">
                    <form action="../controller/add_promo.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Judul Promo</label>
                                <input type="text" name="judul" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Diskon (%)</label>
                                <input type="number" name="diskon" class="form-control" min="1" max="100" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Konsumen</label>
                                <select name="status" class="form-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="member">Member</option>
                                    <option value="biasa">Biasa</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Promo</button>
                    </form>
                </div>
            </div>

            <!-- Tabel Daftar Promo -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-tag-fill"></i> Daftar Promo</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-secondary text-center">
                                <tr>
                                    <th>Judul</th>
                                    <th>Diskon</th>
                                    <th>Periode</th>
                                    <th>Deskripsi</th>
                                    <th>Status Promo</th>
                                    <th>Status Konsumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['judul']) ?></td>
                                        <td><?= $row['diskon'] ?>%</td>
                                        <td class="text-nowrap"><?= $row['tanggal_mulai'] ?> s/d <br><?= $row['tanggal_selesai'] ?></td>
                                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                                        <td class="text-center">
                                            <?php
                                                $today = date("Y-m-d");
                                                echo ($today >= $row['tanggal_mulai'] && $today <= $row['tanggal_selesai'])
                                                    ? '<span class="badge bg-success">Aktif</span>'
                                                    : '<span class="badge bg-secondary">Nonaktif</span>';
                                            ?>
                                        </td>
                                        <td class="text-capitalize text-center"><?= htmlspecialchars($row['status']) ?></td>
                                        <td class="text-center">
                                            <a href="../controller/delete_promo.php?id=<?= $row['id'] ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Hapus promo ini?')">
                                               <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                <?php if ($result->num_rows === 0): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada data promo.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- End Card -->

        </div>
    </div>

    <?php include '../layout/footer.php'; ?>
</div>

</body>
</html>
