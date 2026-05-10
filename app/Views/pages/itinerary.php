<section class="page-head">
    <div>
        <p class="eyebrow">Itinerary View Screen</p>
        <h1>Itinerary for <?= e($trip['name']) ?></h1>
        <p><?= e(date_range($trip['start_date'], $trip['end_date'])) ?> - Budget <?= money($budget['total']) ?></p>
    </div>
    <div class="segmented" role="group" aria-label="View mode">
        <button class="is-active" type="button">List</button>
        <button type="button">Calendar</button>
    </div>
</section>

<section class="itinerary-layout">
    <div class="timeline">
        <?php foreach ($stops as $day => $stop): ?>
            <article class="timeline-day">
                <div class="day-marker">Day <?= $day + 1 ?></div>
                <div class="timeline-body">
                    <h2><?= e($stop['city_name']) ?></h2>
                    <p><?= e(date_range($stop['start_date'], $stop['end_date'])) ?></p>
                    <?php foreach ($stop['activities'] ?? [] as $activity): ?>
                        <div class="timeline-activity">
                            <span><?= e(substr($activity['scheduled_time'] ?? '09:00', 0, 5)) ?></span>
                            <div>
                                <strong><?= e($activity['name']) ?></strong>
                                <p><?= e($activity['type']) ?> - <?= e($activity['duration_hours']) ?> hours</p>
                            </div>
                            <em><?= money($activity['cost']) ?></em>
                        </div>
                    <?php endforeach; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <aside class="budget-strip">
        <h2>Budget section</h2>
        <?php foreach ($budget['items'] as $item): ?>
            <?php $width = max(8, ((float) $item['total'] / (float) $budget['total']) * 100); ?>
            <div class="bar-row">
                <span><?= e($item['category']) ?></span>
                <div><i style="width: <?= e((string) $width) ?>%"></i></div>
                <em><?= money($item['total']) ?></em>
            </div>
        <?php endforeach; ?>
        <a class="button small" href="<?= url('/trips/' . $trip['id'] . '/budget') ?>">Open budget</a>
    </aside>
</section>
