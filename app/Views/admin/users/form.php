<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0"><i class="bi bi-person me-2 text-primary"></i><?= esc($title) ?></h2>
    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i><?= lang('Admin.cancel') ?>
    </a>
</div>

<?php $action = $user ? base_url('admin/users/update/' . $user->id) : base_url('admin/users/store'); ?>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">
        <form action="<?= $action ?>" method="post" novalidate>
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="username" class="form-label fw-semibold"><?= lang('Admin.username') ?> <span class="text-danger">*</span></label>
                    <input type="text" id="username" name="username" class="form-control"
                           value="<?= esc(old('username', $user->username ?? '')) ?>" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="email" class="form-label fw-semibold"><?= lang('Admin.email') ?> <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" class="form-control"
                           value="<?= esc(old('email', $user->email ?? '')) ?>" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="password" class="form-label fw-semibold"><?= lang('Admin.password') ?> <?= $user ? '' : '<span class="text-danger">*</span>' ?></label>
                    <input type="password" id="password" name="password" class="form-control"
                           <?= $user ? '' : 'required' ?> minlength="8" autocomplete="new-password">
                    <?php if ($user): ?>
                    <div class="form-text"><?= lang('Admin.keepPassword') ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-6 col-md-3">
                    <label for="role" class="form-label fw-semibold"><?= lang('Admin.role') ?> <span class="text-danger">*</span></label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="editor" <?= (old('role', $user->role ?? '') === 'editor') ? 'selected' : '' ?>><?= lang('Admin.editor') ?></option>
                        <option value="superadmin" <?= (old('role', $user->role ?? '') === 'superadmin') ? 'selected' : '' ?>><?= lang('Admin.superadmin') ?></option>
                    </select>
                </div>
                <?php if ($user): ?>
                <div class="col-6 col-md-3">
                    <label for="is_active" class="form-label fw-semibold"><?= lang('Admin.active') ?></label>
                    <select id="is_active" name="is_active" class="form-select">
                        <option value="1" <?= (int) ($user->is_active ?? 1) === 1 ? 'selected' : '' ?>><?= lang('Admin.active') ?></option>
                        <option value="0" <?= (int) ($user->is_active ?? 1) === 0 ? 'selected' : '' ?>><?= lang('Admin.inactive') ?></option>
                    </select>
                </div>
                <?php else: ?>
                    <input type="hidden" name="is_active" value="1">
                <?php endif; ?>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-floppy me-2"></i><?= lang('Admin.save') ?>
                </button>
                <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary px-4"><?= lang('Admin.cancel') ?></a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
