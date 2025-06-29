<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}
include '../connect/database.php';
$result = $conn->query("SELECT * FROM konsumen");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Konsumen</title>
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

        .card {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        }

        .card-header {
            background-color: #f06292 !important;
            color: white !important;
            font-weight: 600;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .btn-success {
            border: none;
        }

        .btn-success:hover {
            background-color: #c2185b;
        }

        .badge-member {
            background-color: #ffe0ec;
            color: #c2185b;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 999px;
        }

        .badge-biasa {
            background-color: #e3f2fd;
            color: #0d47a1;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 999px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        h5 {
            font-weight: 600;
        }
    </style>
</head>
<body>

<?php include '../layout/navbar.php'; ?>

<div class="main-content">
    <?php include '../layout/header.php'; ?>

    <div class="content-wrapper">
        <div class="container mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Data Konsumen</h5>
                    <a href="../controller/add_konsumen.php" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Konsumen
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Nama</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                                    <td class="text-center">
                                        <span class="<?= $row['status'] === 'member' ? 'badge-member' : 'badge-biasa' ?>">
                                            <?= ucfirst($row['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="../controller/edit_konsumen.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="../controller/delete_konsumen.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Hapus data konsumen ini?')">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php if ($result->num_rows === 0): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data konsumen.</td>
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
