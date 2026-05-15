<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0"><i class="bi bi-speedometer2 me-2 text-primary"></i><?= lang('Admin.dashboard') ?></h2>
</div>

<div class="row g-3 mb-5">
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-layers-fill display-5 text-warning mb-2"></i>
                <div class="display-6 fw-bold"><?= (int) $totalZones ?></div>
                <div class="text-muted small"><?= lang('Admin.totalZones') ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-check-circle-fill display-5 text-success mb-2"></i>
                <div class="display-6 fw-bold"><?= (int) $publishedZones ?></div>
                <div class="text-muted small"><?= lang('Admin.publishedZones') ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-geo-alt-fill display-5 text-primary mb-2"></i>
                <div class="display-6 fw-bold"><?= (int) $totalStops ?></div>
                <div class="text-muted small"><?= lang('Admin.totalStops') ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-headphones display-5 text-info mb-2"></i>
                <div class="display-6 fw-bold"><?= (int) $publishedStops ?></div>
                <div class="text-muted small"><?= lang('Admin.publishedStops') ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-people-fill display-5 text-secondary mb-2"></i>
                <div class="display-6 fw-bold"><?= (int) $totalUsers ?></div>
                <div class="text-muted small"><?= lang('Admin.totalUsers') ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-md-6">
        <a href="<?= base_url('admin/zones/create') ?>" class="btn btn-warning btn-lg w-100 py-3">
            <i class="bi bi-plus-circle me-2"></i><?= lang('Admin.createZone') ?>
        </a>
    </div>
    <div class="col-12 col-md-6">
        <a href="<?= base_url('admin/stops/create') ?>" class="btn btn-primary btn-lg w-100 py-3">
            <i class="bi bi-plus-circle me-2"></i><?= lang('Admin.createStop') ?>
        </a>
    </div>
    <div class="col-12 col-md-6">
        <a href="<?= base_url('admin/zones') ?>" class="btn btn-outline-warning btn-lg w-100 py-3">
            <i class="bi bi-layers me-2"></i><?= lang('Admin.zones') ?>
        </a>
    </div>
    <div class="col-12 col-md-6">
        <a href="<?= base_url('admin/stops') ?>" class="btn btn-outline-primary btn-lg w-100 py-3">
            <i class="bi bi-list-ul me-2"></i><?= lang('Admin.stops') ?>
        </a>
    </div>
</div>
<?= $this->endSection() ?>
