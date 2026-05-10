<section class="page-head">
    <div>
        <p class="eyebrow"><?= $mode === 'cities' ? 'City Search' : 'Activity Search' ?></p>
        <h1><?= $mode === 'cities' ? 'Discover cities for a trip' : 'Find things to do' ?></h1>
        <p>Filter by destination, interest, cost, and duration before adding to a stop.</p>
    </div>
    <div class="segmented">
        <a class="<?= $mode === 'cities' ? 'is-active' : '' ?>" href="<?= url('/search/cities') ?>">Cities</a>
        <a class="<?= $mode === 'activities' ? 'is-active' : '' ?>" href="<?= url('/search/activities') ?>">Activities</a>
    </div>
</section>

<section class="search-shell">
    <form class="filter-bar" method="get">
        <input type="search" name="q" placeholder="Search by name, region, or activity">
        <select name="region">
            <option value="">Any region</option>
            <?php foreach ($cities as $city): ?>
                <option><?= e($city['region']) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="cost">
            <option value="">Any cost</option>
            <option>Low</option>
            <option>Medium</option>
            <option>High</option>
        </select>
        <button class="button secondary" type="submit">Filter</button>
    </form>

    <?php if ($mode === 'cities'): ?>
        <div class="result-list">
            <?php foreach ($cities as $city): ?>
                <article class="search-result">
                    <img src="<?= asset($city['image']) ?>" alt="">
                    <div>
                        <h2><?= e($city['name']) ?></h2>
                        <p><?= e($city['summary']) ?></p>
                        <span><?= e($city['country']) ?> - <?= e($city['region']) ?> - Popularity <?= e($city['popularity']) ?></span>
                    </div>
                    <button class="button small" type="button">Add to trip</button>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="result-list">
            <?php foreach ($activities as $activity): ?>
                <article class="search-result no-image">
                    <div>
                        <h2><?= e($activity['name']) ?></h2>
                        <p><?= e($activity['summary']) ?></p>
                        <span><?= e($activity['city_name']) ?> - <?= e($activity['type']) ?> - <?= e($activity['duration_hours']) ?> hours - <?= money($activity['cost']) ?></span>
                    </div>
                    <div class="row-actions">
                        <button class="button small" type="button">Add</button>
                        <button class="button small quiet" type="button">Quick view</button>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
