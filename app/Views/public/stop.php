<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<div class="container">
    <a href="<?= base_url($lang) ?>" class="btn btn-outline-secondary btn-sm mb-4">
        <i class="bi bi-arrow-left me-2"></i><?= lang('App.backToList') ?>
    </a>

    <article>
        <h1 class="display-6 fw-bold mb-4"><?= esc($stop->title) ?></h1>

        <!-- Image gallery -->
        <?php if (!empty($images)): ?>
        <div id="stopGallery" class="carousel slide rounded-3 overflow-hidden shadow-sm mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($images as $i => $img): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <img src="<?= base_url('uploads/' . esc($img->file_path)) ?>"
                         class="d-block w-100"
                         style="max-height:420px;object-fit:cover"
                         alt="<?= esc($img->alt_text ?? $stop->title) ?>"
                         loading="<?= $i === 0 ? 'eager' : 'lazy' ?>">
                </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($images) > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#stopGallery" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#stopGallery" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Audio player -->
        <?php if ($stop->audio_url): ?>
        <div class="audio-player-wrapper mb-4 p-3 bg-light rounded-3 border">
            <p class="fw-semibold small mb-2 text-muted text-uppercase tracking-wide">
                <i class="bi bi-music-note-beamed me-2"></i><?= lang('App.listenAudio') ?>
            </p>
            <audio id="audioPlayer" controls class="w-100" aria-label="<?= esc($stop->title) ?>">
                <source src="<?= base_url('uploads/' . esc($stop->audio_url)) ?>" type="audio/mpeg">
            </audio>
        </div>
        <?php endif; ?>

        <!-- Description -->
        <?php if ($stop->description): ?>
        <div class="stop-description mb-4">
            <?= nl2br(esc($stop->description)) ?>
        </div>
        <?php endif; ?>

        <!-- YouTube embed -->
        <?php if ($stop->youtube_url): ?>
        <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm mt-4">
            <iframe src="<?= esc($stop->youtube_url) ?>?rel=0"
                    title="<?= esc($stop->title) ?>"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>
        <?php endif; ?>
    </article>
</div>
<?= $this->endSection() ?>
