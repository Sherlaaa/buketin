<?php
include '../connect/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Pendaftaran gagal. Username mungkin sudah digunakan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - Buketin CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #fff0f5, #fff0f5);
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #e91e63;
            border: none;
        }

        .btn-primary:hover {
            background-color: #c2185b;
        }

        a {
            color: #ec407a;
        }

        a:hover {
            color: #d81b60;
        }
        .logo-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 50%;
            background-color: #fff;
            padding: 6px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-5">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="text-center mb-3">
                        <img src="../assets/floral-design.png" alt="Logo Buketin" class="logo-img mb-2">
                    </div>
                    <div class="brand-logo">BUKETIN</div>
                    <small class="text-muted">CRM Account Registration</small>
                </div>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <select name="role" class="form-select" required>
                            <option value="" disabled selected>Pilih Peran</option>
                            <option value="admin">Admin</option>
                            <option value="sales">Sales</option>
                            <option value="marketing">Marketing</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>
                <div class="text-center mt-3">
                    <p class="mb-0">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
