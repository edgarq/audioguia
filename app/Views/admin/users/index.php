<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i><?= lang('Admin.users') ?></h2>
    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i><?= lang('Admin.createUser') ?>
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th><?= lang('Admin.username') ?></th>
                        <th><?= lang('Admin.email') ?></th>
                        <th class="text-center"><?= lang('Admin.role') ?></th>
                        <th class="text-center"><?= lang('Admin.active') ?></th>
                        <th class="text-end pe-3"><?= lang('Admin.actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td class="ps-3 text-muted"><?= (int) $u->id ?></td>
                    <td class="fw-semibold"><?= esc($u->username) ?></td>
                    <td><?= esc($u->email) ?></td>
                    <td class="text-center">
                        <span class="badge <?= $u->role === 'superadmin' ? 'bg-danger' : 'bg-info text-dark' ?>">
                            <?= lang('Admin.' . $u->role) ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <?php if ($u->is_active): ?>
                            <span class="badge bg-success"><?= lang('Admin.active') ?></span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?= lang('Admin.inactive') ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end pe-3">
                        <a href="<?= base_url('admin/users/edit/' . $u->id) ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <?php if ((int) $u->id !== (int) session()->get('admin_id')): ?>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete"
                                data-action="<?= base_url('admin/users/delete/' . $u->id) ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
