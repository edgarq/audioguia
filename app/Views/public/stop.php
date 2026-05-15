<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<article class="stop-detail">

    <!-- Full-bleed image gallery -->
    <?php if (!empty($images)): ?>
    <div class="stop-detail__gallery">
        <div id="stopGallery" class="carousel slide h-100"
             data-bs-ride="<?= count($images) > 1 ? 'carousel' : 'false' ?>">
            <div class="carousel-inner h-100">
                <?php foreach ($images as $i => $img): ?>
                <div class="carousel-item h-100 <?= $i === 0 ? 'active' : '' ?>">
                    <img src="<?= base_url('uploads/' . esc($img->file_path)) ?>"
                         class="d-block w-100 h-100"
                         style="object-fit:cover"
                         alt="<?= esc($img->alt_text ?? $stop->title) ?>"
                         loading="<?= $i === 0 ? 'eager' : 'lazy' ?>">
                </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($images) > 1): ?>
            <button class="carousel-control-prev" type="button"
                    data-bs-target="#stopGallery" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button"
                    data-bs-target="#stopGallery" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Title -->
    <div class="stop-detail__content">
        <h2 class="stop-detail__title"><?= esc($stop->title) ?></h2>
    </div>

    <!-- Audio player -->
    <?php if ($stop->audio_url): ?>
    <div class="audio-player-wrapper">
        <p class="audio-player-label">
            <i class="bi bi-waveform" aria-hidden="true"></i>
            <?= lang('App.listenAudio') ?>
        </p>
        <audio id="audioPlayer"
               controls
               preload="metadata"
               aria-label="<?= esc($stop->title) ?>">
            <source src="<?= base_url('uploads/' . esc($stop->audio_url)) ?>"
                    type="audio/mpeg">
        </audio>
    </div>
    <?php endif; ?>

    <!-- Description -->
    <?php if ($stop->description): ?>
    <div class="stop-description ql-editor" style="padding:0">
        <?= $stop->description ?>
    </div>
    <?php endif; ?>

    <!-- YouTube embed -->
    <?php if ($stop->youtube_url): ?>
    <div class="stop-video ratio ratio-16x9">
        <iframe src="<?= esc($stop->youtube_url) ?>?rel=0"
                title="<?= esc($stop->title) ?>"
                allow="accelerometer; autoplay; clipboard-write;
                       encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                loading="lazy"
                referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>
    <?php endif; ?>

</article>

<?= $this->endSection() ?>
