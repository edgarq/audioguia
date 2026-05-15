<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<?php if (!empty($zone->cover_image)): ?>
<div class="guide-hero">
    <img src="<?= base_url('uploads/' . esc($zone->cover_image)) ?>"
         class="guide-hero__img" alt="<?= esc($zone->title) ?>">
    <div class="guide-hero__overlay"></div>
    <div class="guide-hero__text">
        <h2><?= esc($zone->title) ?></h2>
        <?php if ($zone->description): ?>
            <p><?= esc(mb_substr(strip_tags($zone->description), 0, 100)) ?></p>
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
<div class="guide-title-block">
    <h2><?= esc($zone->title) ?></h2>
    <?php if ($zone->description): ?>
        <p><?= esc(mb_substr(strip_tags($zone->description), 0, 120)) ?></p>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if (empty($stops)): ?>
    <div class="empty-state">
        <i class="bi bi-headphones" aria-hidden="true"></i>
        <p><?= lang('App.noDescription') ?></p>
    </div>
<?php else: ?>

    <div class="stop-count-bar">
        <?= count($stops) ?> <?= lang('App.navStops') ?>
    </div>

    <ol class="stop-list" aria-label="<?= esc($zone->title) ?>">
        <?php foreach ($stops as $i => $stop): ?>
        <li>
            <a href="<?= base_url($lang . '/stop/' . esc($stop->slug)) ?>"
               class="stop-card"
               aria-label="<?= ($i + 1) . ': ' . esc($stop->title) ?>">

                <span class="stop-card__number" aria-hidden="true"><?= $i + 1 ?></span>

                <div class="stop-card__body">
                    <p class="stop-card__title"><?= esc($stop->title) ?></p>
                    <?php if ($stop->description): ?>
                        <p class="stop-card__snippet">
                            <?= esc(mb_substr(strip_tags($stop->description), 0, 80)) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <i class="bi bi-chevron-right stop-card__chevron" aria-hidden="true"></i>
            </a>
        </li>
        <?php endforeach; ?>
    </ol>

<?php endif; ?>

<?= $this->endSection() ?>
