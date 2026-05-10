<section class="page-head">
    <div>
        <p class="eyebrow">Build Itinerary Screen</p>
        <h1><?= e($trip['name']) ?></h1>
        <p><?= e($trip['description']) ?></p>
    </div>
    <a class="button primary" href="<?= url('/search/cities') ?>">Add stop</a>
</section>

<section class="builder-grid">
    <div class="builder-list">
        <?php foreach ($stops as $index => $stop): ?>
            <article class="stop-section">
                <div class="stop-section-head">
                    <div>
                        <span>Section <?= $index + 1 ?></span>
                        <h2><?= e($stop['city_name']) ?></h2>
                    </div>
                    <button class="icon-button" type="button" title="Reorder section">&#8597;</button>
                </div>
                <p><?= e($stop['note']) ?></p>
                <dl class="inline-dl">
                    <div><dt>Date range</dt><dd><?= e(date_range($stop['start_date'], $stop['end_date'])) ?></dd></div>
                    <div><dt>Budget</dt><dd><?= money(array_sum(array_map(fn (array $activity): float => (float) $activity['cost'], $stop['activities'] ?? []))) ?></dd></div>
                </dl>
                <div class="activity-stack">
                    <?php foreach ($stop['activities'] ?? [] as $activity): ?>
                        <div class="activity-pill">
                            <span><?= e(substr($activity['scheduled_time'] ?? '09:00', 0, 5)) ?></span>
                            <strong><?= e($activity['name']) ?></strong>
                            <em><?= money($activity['cost']) ?></em>
                        </div>
                    <?php endforeach; ?>
                </div>
            </article>
        <?php endforeach; ?>
        <a class="button secondary full" href="<?= url('/search/cities') ?>">Add another section</a>
    </div>

    <aside class="builder-aside">
        <h2>Quick add</h2>
        <form class="compact-form">
            <label>
                <span>City</span>
                <select>
                    <?php foreach ($cities as $city): ?>
                        <option><?= e($city['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                <span>Activity</span>
                <select>
                    <?php foreach ($activities as $activity): ?>
                        <option><?= e($activity['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button class="button primary" type="button">Attach to stop</button>
        </form>
    </aside>
</section>
