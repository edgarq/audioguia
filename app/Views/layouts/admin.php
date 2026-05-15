<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin') ?> — AudioGuía Admin</title>
    <meta name="csrf-token" data-name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary px-3 sticky-top">
    <span class="navbar-brand fw-bold"><i class="bi bi-headphones me-2"></i>AudioGuía Admin</span>
    <div class="d-flex align-items-center gap-3">
        <span class="text-white-50 small d-none d-md-inline"><i class="bi bi-person-circle me-1"></i><?= esc($adminUser ?? '') ?></span>
        <a href="<?= base_url('admin/logout') ?>" class="btn btn-sm btn-outline-light">
            <i class="bi bi-box-arrow-right me-1"></i><?= lang('Admin.logout') ?>
        </a>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 col-lg-2 d-none d-md-block bg-white sidebar py-3 border-end min-vh-100">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= (uri_string() === 'admin/dashboard') ? 'active fw-bold' : 'text-dark' ?>" href="<?= base_url('admin/dashboard') ?>">
                        <i class="bi bi-speedometer2 me-2"></i><?= lang('Admin.dashboard') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_starts_with(uri_string(), 'admin/zones') ? 'active fw-bold' : 'text-dark' ?>" href="<?= base_url('admin/zones') ?>">
                        <i class="bi bi-layers me-2"></i><?= lang('Admin.zones') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_starts_with(uri_string(), 'admin/stops') ? 'active fw-bold' : 'text-dark' ?>" href="<?= base_url('admin/stops') ?>">
                        <i class="bi bi-geo-alt me-2"></i><?= lang('Admin.stops') ?>
                    </a>
                </li>
                <?php if (($adminRole ?? '') === 'superadmin'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= str_starts_with(uri_string(), 'admin/users') ? 'active fw-bold' : 'text-dark' ?>" href="<?= base_url('admin/users') ?>">
                        <i class="bi bi-people me-2"></i><?= lang('Admin.users') ?>
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item mt-3">
                    <a class="nav-link text-secondary small" href="<?= base_url('es') ?>" target="_blank">
                        <i class="bi bi-eye me-2"></i>Ver audioguía
                    </a>
                </li>
            </ul>
        </nav>

        <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4 py-3">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach ((array) session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
<script src="<?= base_url('assets/js/admin-quill.js') ?>"></script>
</body>
</html>
