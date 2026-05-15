<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<div class="guide-title-block">
    <h1><?= esc(lang('App.guideTitle')) ?></h1>
    <p><?= esc(lang('App.guideSubtitle')) ?></p>
</div>

<?php if (empty($zones)): ?>
    <div class="empty-state">
        <i class="bi bi-map" aria-hidden="true"></i>
        <p><?= lang('App.noDescription') ?></p>
    </div>
<?php else: ?>

    <div class="stop-count-bar">
        <?= count($zones) ?> <?= lang('App.zones') ?>
    </div>

    <ol class="stop-list" aria-label="<?= esc(lang('App.guideTitle')) ?>">
        <?php foreach ($zones as $i => $zone): ?>
        <li>
            <a href="<?= base_url($lang . '/zone/' . esc($zone->slug)) ?>"
               class="stop-card"
               aria-label="<?= esc($zone->title) ?>">

                <?php if ($zone->cover_image): ?>
                    <img src="<?= base_url('uploads/' . esc($zone->cover_image)) ?>"
                         class="stop-card__thumb"
                         alt="<?= esc($zone->title) ?>"
                         loading="lazy">
                <?php else: ?>
                    <span class="stop-card__number" aria-hidden="true"><?= $i + 1 ?></span>
                <?php endif; ?>

                <div class="stop-card__body">
                    <p class="stop-card__title"><?= esc($zone->title) ?></p>
                    <?php if ($zone->description): ?>
                        <p class="stop-card__snippet">
                            <?= esc(mb_substr(strip_tags($zone->description), 0, 80)) ?>
                        </p>
                    <?php endif; ?>
                    <?php if (isset($zone->stop_count)): ?>
                        <p class="stop-card__snippet" style="color:var(--pat-accent)">
                            <?= (int) $zone->stop_count ?> <?= lang('App.navStops') ?>
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
