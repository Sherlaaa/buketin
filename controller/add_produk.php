<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../authentikasi/login.php");
    exit;
}
include '../connect/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $warna = $_POST['warna'];
    $harga = $_POST['harga'];

    // Upload Gambar
    $gambar_name = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $upload_dir = '../uploads/';
    $gambar_path = $upload_dir . basename($gambar_name);
    move_uploaded_file($gambar_tmp, $gambar_path);

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO produk (nama, warna, harga, gambar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $nama, $warna, $harga, $gambar_name);
    $stmt->execute();

    header("Location: ../view/produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="card">
            <div class="card-header bg-primary text-white">Tambah Produk</div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <select name="nama" class="form-select" required>
                            <option value="">-- Pilih Jenis Buket --</option>
                            <option value="Buket Bunga">Buket Bunga</option>
                            <option value="Buket Uang">Buket Uang</option>
                            <option value="Buket Boneka">Buket Boneka</option>
                            <option value="Buket Snack">Buket Snack</option>
                            <option value="Buket Balon">Buket Balon</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Warna</label>
                        <select name="warna" class="form-select" required>
                            <option value="">-- Pilih Warna --</option>
                            <option value="Merah">Merah</option>
                            <option value="Putih">Putih</option>
                            <option value="Kuning">Kuning</option>
                            <option value="Merah Muda">Merah Muda</option>
                            <option value="Ungu">Ungu</option>
                            <option value="Biru">Biru</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Upload Gambar</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="../view/produk.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>
</div>
</body>
</html>
