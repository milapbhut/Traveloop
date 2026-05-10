<?php
$groups = [
    'Ongoing' => array_filter($trips, fn (array $trip): bool => ($trip['status'] ?? '') === 'ongoing'),
    'Upcoming' => array_filter($trips, fn (array $trip): bool => ($trip['status'] ?? '') === 'upcoming'),
    'Completed' => array_filter($trips, fn (array $trip): bool => ($trip['status'] ?? '') === 'completed'),
];
?>
<section class="page-head">
    <div>
        <p class="eyebrow">User Trip Listing</p>
        <h1>My Trips</h1>
        <p>Review, edit, share, or delete travel plans by status.</p>
    </div>
    <a class="button primary" href="<?= url('/trips/create') ?>">Plan a trip</a>
</section>

<?php foreach ($groups as $label => $items): ?>
    <section class="list-section">
        <h2><?= e($label) ?></h2>
        <?php if (!$items): ?>
            <p class="empty">No <?= strtolower($label) ?> trips yet.</p>
        <?php endif; ?>
        <?php foreach ($items as $trip): ?>
            <article class="wide-row">
                <img src="<?= asset($trip['cover_photo']) ?>" alt="">
                <div>
                    <h3><?= e($trip['name']) ?></h3>
                    <p><?= e($trip['description']) ?></p>
                    <span><?= e(date_range($trip['start_date'], $trip['end_date'])) ?> - <?= e($trip['city_count']) ?> destinations - <?= money($trip['spent']) ?></span>
                </div>
                <div class="row-actions">
                    <a class="button small" href="<?= url('/trips/' . $trip['id']) ?>">View</a>
                    <a class="button small secondary" href="<?= url('/trips/' . $trip['id'] . '/builder') ?>">Edit</a>
                    <a class="button small quiet" href="<?= url('/share/' . $trip['share_code']) ?>">Share</a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
<?php endforeach; ?>
