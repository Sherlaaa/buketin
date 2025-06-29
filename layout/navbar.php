<div class="sidebar position-fixed text-white shadow-sm d-flex flex-column" style="width:250px; height:100vh; background-color: #c2185b;">
    <!-- Logo dan Brand -->
    <div class="p-4 border-bottom text-center">
        <img src="../assets/floral-design.png" alt="Logo Buketin" style="width: 60px; height: auto;" class="mb-2">
        <h5 class="mb-0 fw-bold">BUKETIN</h5>
        <small class="text-white-50">CRM Management</small>
    </div>

    <!-- Menu Navigasi -->
    <nav class="flex-grow-1 d-flex flex-column mt-3">
        <a href="../view/dashboard.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="../view/user.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-person-gear"></i> Data User
            </a>
            <a href="../view/produk.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-box-seam"></i> Data Produk
            </a>
            <a href="../view/konsumen.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-people-fill"></i> Data Konsumen
            </a>
            <a href="../view/report.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-clipboard-data"></i> Laporan
            </a>

        <?php elseif ($_SESSION['role'] === 'sales'): ?>
            <a href="../view/katalog.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-journal-text"></i> Data Katalog
            </a>
            <a href="../view/konsumen.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-people-fill"></i> Data Konsumen
            </a>
            <a href="../view/penjualan.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-cart-check"></i> Data Penjualan
            </a>
            <a href="../view/report.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-bar-chart-line-fill"></i> Laporan
            </a>

        <?php elseif ($_SESSION['role'] === 'marketing'): ?>
            <a href="../view/promo.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-megaphone-fill"></i> Data Promo
            </a>
            <a href="../view/report.php" class="text-white px-3 py-2 text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-bar-chart-line-fill"></i> Laporan
            </a>
        <?php endif; ?>
    </nav>

    <!-- Logout -->
    <a href="../authentikasi/logout.php" class="text-white px-3 py-3 text-decoration-none border-top d-flex align-items-center gap-2">
        <i class="bi bi-box-arrow-left"></i> Logout
    </a>
</div>
