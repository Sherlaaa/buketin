<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}
include '../connect/database.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM produk WHERE id='$id'");
$row = $data->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $warna = $_POST['warna'];
    $harga = $_POST['harga'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar_baru = $_FILES['gambar']['name'];
        $tmp_gambar = $_FILES['gambar']['tmp_name'];
        $upload_path = '../uploads/' . $gambar_baru;

        if (file_exists('../uploads/' . $row['gambar'])) {
            unlink('../uploads/' . $row['gambar']);
        }

        move_uploaded_file($tmp_gambar, $upload_path);

        $stmt = $conn->prepare("UPDATE produk SET nama = ?, warna = ?, harga = ?, gambar = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $nama, $warna, $harga, $gambar_baru, $id);
    } else {
        $stmt = $conn->prepare("UPDATE produk SET nama = ?, warna = ?, harga = ? WHERE id = ?");
        $stmt->bind_param("ssii", $nama, $warna, $harga, $id);
    }

    $stmt->execute();
    header("Location: ../view/produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
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
            <div class="card shadow">
                <div class="card-header bg-warning text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square me-2"></i>
                    <h5 class="mb-0">Edit Data Produk</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama">Nama Produk</label>
                            <select name="nama" id="nama" class="form-select" required>
                                <?php
                                $produkList = ['Buket Bunga', 'Buket Uang', 'Buket Boneka', 'Buket Snack', 'Buket Balon'];
                                foreach ($produkList as $item) {
                                    $selected = $row['nama'] == $item ? 'selected' : '';
                                    echo "<option value='$item' $selected>$item</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="warna">Warna</label>
                            <select name="warna" id="warna" class="form-select" required>
                                <?php
                                $warnaList = ['Merah', 'Putih', 'Kuning', 'Merah Muda', 'Ungu', 'Biru'];
                                foreach ($warnaList as $warna) {
                                    $selected = $row['warna'] == $warna ? 'selected' : '';
                                    echo "<option value='$warna' $selected>$warna</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="harga">Harga (Rp)</label>
                            <input type="number" name="harga" id="harga" class="form-control" value="<?= $row['harga'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="gambar">Ganti Gambar (Opsional)</label>
                            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                            <div class="mt-3">
                                <strong>Gambar Saat Ini:</strong><br>
                                <img src="../uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar" width="150" class="preview-img">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="../view/produk.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../layout/footer.php'; ?>
</div>
</body>
</html>
