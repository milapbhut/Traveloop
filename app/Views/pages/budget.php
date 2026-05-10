<?php
$percent = min(100, ((float) $budget['total'] / max(1, (float) $budget['limit'])) * 100);
?>
<section class="page-head">
    <div>
        <p class="eyebrow">Trip Budget and Cost Breakdown</p>
        <h1><?= e($trip['name']) ?> budget</h1>
        <p>Estimated total, category breakdowns, and over-budget alerts.</p>
    </div>
    <a class="button secondary" href="<?= url('/trips/' . $trip['id'] . '/invoice') ?>">Open invoice</a>
</section>

<section class="budget-grid">
    <article class="budget-summary">
        <p class="eyebrow">Estimated total</p>
        <strong><?= money($budget['total']) ?></strong>
        <span>Average per day: <?= money($budget['average_day']) ?></span>
        <div class="progress">
            <i style="width: <?= e((string) $percent) ?>%"></i>
        </div>
        <p class="<?= $percent > 90 ? 'alert' : 'muted' ?>">
            <?= $percent > 90 ? 'Watch this plan: it is close to the budget limit.' : 'This plan is inside the target budget.' ?>
        </p>
    </article>

    <article class="donut-card">
        <div class="donut" style="--value: <?= e((string) $percent) ?>"></div>
        <h2><?= e((string) round($percent)) ?>% used</h2>
        <p>Compared with <?= money($budget['limit']) ?> target.</p>
    </article>

    <article class="breakdown-panel">
        <h2>Breakdown</h2>
        <?php foreach ($budget['items'] as $item): ?>
            <?php $width = max(8, ((float) $item['total'] / (float) $budget['total']) * 100); ?>
            <div class="bar-row">
                <span><?= e($item['category']) ?></span>
                <div><i style="width: <?= e((string) $width) ?>%"></i></div>
                <em><?= money($item['total']) ?></em>
            </div>
        <?php endforeach; ?>
    </article>
</section>
