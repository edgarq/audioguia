<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0"><i class="bi bi-layers me-2 text-primary"></i><?= lang('Admin.zones') ?></h2>
    <a href="<?= base_url('admin/zones/create') ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i><?= lang('Admin.createZone') ?>
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th><?= lang('Admin.title') ?></th>
                        <th><?= lang('Admin.slug') ?></th>
                        <th class="text-center"><?= lang('Admin.sortOrder') ?></th>
                        <th class="text-center"><?= lang('Admin.published') ?></th>
                        <th class="text-end pe-3"><?= lang('Admin.actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($zones)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">No hay zonas.</td></tr>
                <?php else: ?>
                    <?php foreach ($zones as $zone): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= (int) $zone->id ?></td>
                        <td class="fw-semibold"><?= esc($zone->title) ?></td>
                        <td><code><?= esc($zone->slug) ?></code></td>
                        <td class="text-center"><?= (int) $zone->sort_order ?></td>
                        <td class="text-center">
                            <?php if ($zone->is_published): ?>
                                <span class="badge bg-success"><?= lang('Admin.published') ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= lang('Admin.draft') ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-3">
                            <a href="<?= base_url('admin/zones/edit/' . $zone->id) ?>" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete"
                                    data-action="<?= base_url('admin/zones/delete/' . $zone->id) ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
