<div class="bg-white border-bottom shadow-sm py-3 px-4 d-flex justify-content-end align-items-center gap-3"
     style="position: fixed; top: 0; left: 250px; right: 0; height: 70px; z-index: 1000;">
    <button class="btn btn-light position-relative" title="Notifikasi">
        <i class="bi bi-bell text-danger fs-5"></i>
    </button>
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-2 fs-5 text-secondary"></i>
            <?= htmlspecialchars($_SESSION['role']) ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="bi bi-bell me-2"></i> Notifikasi</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../authentikasi/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
        </ul>
    </div>
</div>
