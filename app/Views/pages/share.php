<section class="public-hero">
    <img src="<?= asset($trip['cover_photo']) ?>" alt="">
    <div>
        <p class="eyebrow">Shared/Public Itinerary View</p>
        <h1><?= e($trip['name']) ?></h1>
        <p><?= e($trip['description']) ?></p>
        <div class="button-row">
            <button class="button primary" type="button" data-copy="<?= e(url('/share/' . $trip['share_code'])) ?>">Copy trip link</button>
            <a class="button secondary" href="<?= url('/trips/create') ?>">Copy trip</a>
        </div>
    </div>
</section>

<section class="readonly-itinerary">
    <?php foreach ($stops as $stop): ?>
        <article class="wide-row">
            <img src="<?= asset($stop['image']) ?>" alt="">
            <div>
                <h2><?= e($stop['city_name']) ?></h2>
                <p><?= e($stop['note']) ?></p>
                <span><?= e(date_range($stop['start_date'], $stop['end_date'])) ?></span>
            </div>
        </article>
    <?php endforeach; ?>
</section>
