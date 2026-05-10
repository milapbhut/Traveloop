<?php $counts = $stats['counts']; ?>
<section class="page-head">
    <div>
        <p class="eyebrow">Admin / Analytics Dashboard</p>
        <h1>Platform analytics</h1>
        <p>Monitor trip creation, popular cities, activity engagement, and users.</p>
    </div>
</section>

<section class="metric-grid">
    <div class="metric"><span><?= e($counts['users']) ?></span><p>Users</p></div>
    <div class="metric"><span><?= e($counts['trips']) ?></span><p>Trips</p></div>
    <div class="metric"><span><?= e($counts['cities']) ?></span><p>Cities</p></div>
    <div class="metric"><span><?= e($counts['activities']) ?></span><p>Activities</p></div>
</section>

<section class="admin-grid">
    <article class="breakdown-panel">
        <h2>Top cities</h2>
        <?php
        $max = max(1, max(array_map(fn (array $city): int => (int) $city['trips'], $stats['top_cities'])));
        foreach ($stats['top_cities'] as $city):
            $width = ((int) $city['trips'] / $max) * 100;
        ?>
            <div class="bar-row">
                <span><?= e($city['name']) ?></span>
                <div><i style="width: <?= e((string) $width) ?>%"></i></div>
                <em><?= e($city['trips']) ?></em>
            </div>
        <?php endforeach; ?>
    </article>

    <article class="table-panel">
        <h2>User trip data</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Trip</th>
                    <th>Status</th>
                    <th>Stops</th>
                    <th>Budget</th>
                    <th>Share</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trips as $trip): ?>
                    <tr>
                        <td><?= e($trip['name']) ?></td>
                        <td><?= e($trip['status']) ?></td>
                        <td><?= e($trip['city_count']) ?></td>
                        <td><?= money($trip['spent']) ?></td>
                        <td><a href="<?= url('/share/' . $trip['share_code']) ?>">Open</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </article>
</section>
