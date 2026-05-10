<?php
$currentTrip = $trips[0] ?? null;
$upcoming = array_values(array_filter($trips, fn (array $trip): bool => ($trip['status'] ?? '') !== 'completed'));
?>
<section class="dashboard-banner">
    <div>
        <p class="eyebrow">Main Landing Page</p>
        <h1>Plan multi-city trips without losing the thread.</h1>
        <p>Build stops, compare budgets, search activities, and share a finished itinerary from one workspace.</p>
        <div class="button-row">
            <a class="button primary" href="<?= url('/trips/create') ?>">Plan new trip</a>
            <?php if ($currentTrip): ?>
                <a class="button secondary" href="<?= url('/trips/' . $currentTrip['id'] . '/builder') ?>">Open builder</a>
            <?php endif; ?>
        </div>
    </div>
    <img src="<?= asset('assets/img/traveloop-cover.jpg') ?>" alt="Illustrated travel route over mountains">
</section>

<section class="metric-grid" aria-label="Trip highlights">
    <div class="metric">
        <span><?= count($trips) ?></span>
        <p>Total trips</p>
    </div>
    <div class="metric">
        <span><?= count($upcoming) ?></span>
        <p>Active plans</p>
    </div>
    <div class="metric">
        <span><?= $currentTrip ? money($currentTrip['spent']) : '$0' ?></span>
        <p>Tracked budget</p>
    </div>
    <div class="metric">
        <span><?= count($cities) ?></span>
        <p>City ideas</p>
    </div>
</section>

<section class="section-head">
    <div>
        <p class="eyebrow">Top regional selections</p>
        <h2>Recommended destinations</h2>
    </div>
    <a class="text-link" href="<?= url('/search/cities') ?>">Browse all</a>
</section>

<section class="city-grid">
    <?php foreach (array_slice($cities, 0, 4) as $city): ?>
        <article class="city-card">
            <img src="<?= asset($city['image']) ?>" alt="<?= e($city['name']) ?> city illustration">
            <div>
                <h3><?= e($city['name']) ?></h3>
                <p><?= e($city['region']) ?> - Cost index <?= e($city['cost_index']) ?></p>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<section class="section-head">
    <div>
        <p class="eyebrow">Previous trips</p>
        <h2>Recent itinerary work</h2>
    </div>
    <a class="text-link" href="<?= url('/trips') ?>">Manage trips</a>
</section>

<section class="trip-card-grid">
    <?php foreach ($trips as $trip): ?>
        <article class="trip-card">
            <img src="<?= asset($trip['cover_photo']) ?>" alt="<?= e($trip['name']) ?> cover">
            <div class="trip-card-body">
                <span class="status"><?= e($trip['status']) ?></span>
                <h3><?= e($trip['name']) ?></h3>
                <p><?= e($trip['description']) ?></p>
                <dl>
                    <div><dt>Dates</dt><dd><?= e(date_range($trip['start_date'], $trip['end_date'])) ?></dd></div>
                    <div><dt>Stops</dt><dd><?= e($trip['city_count']) ?></dd></div>
                    <div><dt>Budget</dt><dd><?= money($trip['spent']) ?> / <?= money($trip['budget_limit']) ?></dd></div>
                </dl>
                <a class="button small" href="<?= url('/trips/' . $trip['id']) ?>">View</a>
            </div>
        </article>
    <?php endforeach; ?>
</section>
