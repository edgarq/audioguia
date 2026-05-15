<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 fw-bold mb-0">
        <i class="bi bi-geo-alt me-2 text-primary"></i><?= esc($title) ?>
    </h2>
    <a href="<?= base_url('admin/stops') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i><?= lang('Admin.cancel') ?>
    </a>
</div>

<?php
$action    = $stop ? base_url('admin/stops/update/' . $stop->id) : base_url('admin/stops/store');
$method    = 'post';
?>

<form action="<?= $action ?>" method="<?= $method ?>" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>

    <!-- Basic Info -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white fw-semibold border-bottom py-3">
            <i class="bi bi-info-circle me-2"></i>Información General
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="zone_id" class="form-label fw-semibold"><?= lang('Admin.zone') ?></label>
                    <select id="zone_id" name="zone_id" class="form-select">
                        <?php foreach ($zones as $zId => $zTitle): ?>
                            <option value="<?= esc($zId) ?>"
                                <?= old('zone_id', $stop->zone_id ?? '') == $zId ? 'selected' : '' ?>>
                                <?= esc($zTitle) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="slug" class="form-label fw-semibold"><?= lang('Admin.slug') ?> <span class="text-danger">*</span></label>
                    <input type="text" id="slug" name="slug" class="form-control font-monospace"
                           value="<?= esc(old('slug', $stop->slug ?? '')) ?>"
                           pattern="[a-zA-Z0-9\-]+" required
                           placeholder="entrada-principal">
                    <div class="form-text">Solo letras, números y guiones.</div>
                </div>
                <div class="w-100"></div>
                <div class="col-6 col-md-3">
                    <label for="sort_order" class="form-label fw-semibold"><?= lang('Admin.sortOrder') ?></label>
                    <input type="number" id="sort_order" name="sort_order" class="form-control"
                           value="<?= esc(old('sort_order', $stop->sort_order ?? 0)) ?>" min="0">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-semibold"><?= lang('Admin.published') ?></label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_published"
                               name="is_published" value="1"
                               <?= (old('is_published', $stop->is_published ?? 0)) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_published"><?= lang('Admin.published') ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Translations -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white border-bottom py-0">
            <ul class="nav nav-tabs card-header-tabs" id="langTabs" role="tablist">
                <?php foreach (['es' => 'ES 🇪🇸', 'en' => 'EN 🇬🇧', 'fr' => 'FR 🇫🇷'] as $code => $label): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $code === 'es' ? 'active' : '' ?>"
                            id="tab-<?= $code ?>" data-bs-toggle="tab"
                            data-bs-target="#pane-<?= $code ?>" type="button" role="tab">
                        <?= $label ?>
                    </button>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <?php foreach (['es' => 'Español', 'en' => 'English', 'fr' => 'Français'] as $code => $langName):
                    $t = $trans[$code] ?? null; ?>
                <div class="tab-pane fade <?= $code === 'es' ? 'show active' : '' ?>" id="pane-<?= $code ?>" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold"><?= lang('Admin.title') ?> (<?= $langName ?>)</label>
                            <input type="text" name="trans_<?= $code ?>[title]" class="form-control"
                                   value="<?= esc(old("trans_{$code}[title]", $t->title ?? '')) ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold"><?= lang('Admin.description') ?> (<?= $langName ?>)</label>
                            <textarea name="trans_<?= $code ?>[description]" class="form-control" rows="5"><?= esc(old("trans_{$code}[description]", $t->description ?? '')) ?></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold"><?= lang('Admin.youtubeUrl') ?></label>
                            <input type="url" name="trans_<?= $code ?>[youtube_url]" class="form-control"
                                   value="<?= esc(old("trans_{$code}[youtube_url]", $t->youtube_url ?? '')) ?>"
                                   placeholder="https://www.youtube.com/watch?v=...">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold"><?= lang('Admin.audioFile') ?></label>
                            <?php if (!empty($t->audio_url)): ?>
                                <div class="mb-2">
                                    <audio controls class="w-100" style="height:40px">
                                        <source src="<?= base_url('uploads/' . esc($t->audio_url)) ?>" type="audio/mpeg">
                                    </audio>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="audio_<?= $code ?>" class="form-control" accept="audio/mpeg,.mp3">
                            <div class="form-text">MP3, máx. 50 MB.</div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Images -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white fw-semibold border-bottom py-3">
            <i class="bi bi-images me-2"></i><?= lang('Admin.images') ?>
        </div>
        <div class="card-body">
            <?php if (!empty($images)): ?>
            <div class="row g-2 mb-3" id="imageGrid">
                <?php foreach ($images as $img): ?>
                <div class="col-6 col-md-3 col-lg-2 position-relative" id="imgwrap-<?= $img->id ?>">
                    <img src="<?= base_url('uploads/' . esc($img->file_path)) ?>" class="img-thumbnail w-100"
                         style="height:100px;object-fit:cover" alt="<?= esc($img->alt_text ?? '') ?>" loading="lazy">
                    <button type="button"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 btn-del-img"
                            data-id="<?= $img->id ?>"
                            data-url="<?= base_url('admin/stops/delete-image/' . $img->id) ?>"
                            aria-label="Eliminar imagen">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <label class="form-label fw-semibold"><?= lang('Admin.uploadImages') ?></label>
            <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
            <div class="form-text">JPG / PNG / WebP, máx. 5 MB por imagen.</div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-floppy me-2"></i><?= lang('Admin.save') ?>
        </button>
        <a href="<?= base_url('admin/stops') ?>" class="btn btn-outline-secondary px-4"><?= lang('Admin.cancel') ?></a>
    </div>
</form>
<?= $this->endSection() ?>
