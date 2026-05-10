<section class="page-head">
    <div>
        <p class="eyebrow">Create a New Trip</p>
        <h1>Start a personalized itinerary</h1>
        <p>Add the trip basics, then pick suggested places and activities.</p>
    </div>
</section>

<section class="form-and-suggestions">
    <form class="panel-form" action="<?= url('/trips') ?>" method="post">
        <h2>Plan a new trip</h2>
        <label>
            <span>Trip name</span>
            <input type="text" name="name" placeholder="Traveloop" required>
        </label>
        <div class="two-col">
            <label>
                <span>Start date</span>
                <input type="date" name="start_date" required>
            </label>
            <label>
                <span>End date</span>
                <input type="date" name="end_date" required>
            </label>
        </div>
        <label>
            <span>Budget limit</span>
            <input type="number" name="budget_limit" min="0" step="50" value="1800">
        </label>
        <label>
            <span>Description</span>
            <textarea name="description" rows="5" placeholder="Who is going, travel style, must-see places"></textarea>
        </label>
        <button class="button primary" type="submit">Save trip</button>
    </form>

    <div class="suggestion-panel">
        <h2>Suggestions for places and activities</h2>
        <div class="mini-grid">
            <?php foreach (array_slice($cities, 0, 3) as $city): ?>
                <article class="mini-card">
                    <img src="<?= asset($city['image']) ?>" alt="">
                    <h3><?= e($city['name']) ?></h3>
                    <p><?= e($city['summary']) ?></p>
                </article>
            <?php endforeach; ?>
            <?php foreach (array_slice($activities, 0, 3) as $activity): ?>
                <article class="mini-card line-only">
                    <h3><?= e($activity['name']) ?></h3>
                    <p><?= e($activity['type']) ?> - <?= e($activity['duration_hours']) ?> hrs - <?= money($activity['cost']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
