<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<div class="guide-title-block">
    <h1><?= esc(lang('App.guideTitle')) ?></h1>
    <p><?= esc(lang('App.guideSubtitle')) ?></p>
</div>

<?php if (empty($stops)): ?>
    <div class="empty-state">
        <i class="bi bi-headphones" aria-hidden="true"></i>
        <p><?= lang('App.noDescription') ?></p>
    </div>
<?php else: ?>

    <div class="stop-count-bar">
        <?= count($stops) ?> <?= lang('App.navStops') ?? 'paradas' ?>
    </div>

    <ol class="stop-list" aria-label="<?= esc(lang('App.guideTitle')) ?>">
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
