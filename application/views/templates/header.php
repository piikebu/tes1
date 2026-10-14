<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>

    <nav class="navbar">
        <div class="navbar-inner">
            <a href="<?= base_url() ?>" class="navbar-brand">
                <img src="<?= base_url('assets/img/logo-unsrat.png') ?>" alt="Logo UNSRAT" style="width: 120px; height: 120px;">
            </a>
            <!-- <ul class="navbar-nav">
                <li><a href="<?= base_url() ?>"><i class="fas fa-home"></i> Beranda</a></li>
            </ul> -->

            <!-- Demo Role Switcher -->
            <?php
            $current_role = $_COOKIE['demo_role'] ?? 'user';
            $is_admin = ($current_role === 'admin_dosen');
            ?>
            <div class="role-switcher">
                <button class="role-switcher-btn" id="roleSwitcherBtn" aria-expanded="false">
                    <span class="role-badge <?= $is_admin ? 'role-admin' : 'role-user' ?>">
                        <i class="fas <?= $is_admin ? 'fa-user-shield' : 'fa-user' ?>"></i>
                        <?= $is_admin ? 'Admin/Dosen' : 'User' ?>
                    </span>
                    <i class="fas fa-chevron-down role-chevron"></i>
                </button>
                <div class="role-dropdown" id="roleDropdown">
                    <p class="role-dropdown-label">Mode Demo</p>
                    <a href="<?= base_url('demo/switch_role/admin_dosen') ?>" class="role-option <?= $is_admin ? 'active' : '' ?>">
                        <i class="fas fa-user-shield"></i>
                        <span>
                            <strong>Admin / Dosen</strong>
                            <small>Dapat tambah & edit data</small>
                        </span>
                        <?php if ($is_admin): ?><i class="fas fa-check role-check"></i><?php endif; ?>
                    </a>
                    <a href="<?= base_url('demo/switch_role/user') ?>" class="role-option <?= !$is_admin ? 'active' : '' ?>">
                        <i class="fas fa-user"></i>
                        <span>
                            <strong>Pengguna Umum</strong>
                            <small>Hanya bisa melihat data</small>
                        </span>
                        <?php if (!$is_admin): ?><i class="fas fa-check role-check"></i><?php endif; ?>
                    </a>
                </div>
            </div>

        </div>
    </nav>
    <main class="main-content">