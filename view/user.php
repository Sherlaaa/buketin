<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data User</title>
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

<!-- Sidebar -->
<?php include '../layout/navbar.php'; ?>

<!-- Main Content -->
<div class="main-content">

    <!-- Header -->
    <?php include '../layout/header.php'; ?>

    <!-- Page Content -->
    <div class="content-wrapper">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white rounded-top">
                    <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Data Pengguna</h5>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">Role</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../connect/database.php';
                                $result = $conn->query("SELECT * FROM users");
                                while ($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars(ucfirst($row['role'])) ?></span></td>
                                    <td class="text-center">
                                        <a href="../controller/delete_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger btn-action" title="Hapus" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../layout/footer.php'; ?>

</div>
</body>
</html>
