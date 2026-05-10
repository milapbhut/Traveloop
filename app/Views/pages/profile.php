<section class="page-head">
    <div>
        <p class="eyebrow">User Profile / Settings Screen</p>
        <h1>Profile settings</h1>
        <p>Update account details, language preference, privacy, and saved destinations.</p>
    </div>
</section>

<section class="profile-layout">
    <form class="profile-card">
        <div class="avatar-large"><?= e(substr($user['name'] ?? 'U', 0, 1)) ?></div>
        <label>
            <span>Name</span>
            <input type="text" value="<?= e($user['name'] ?? '') ?>">
        </label>
        <label>
            <span>Email</span>
            <input type="email" value="<?= e($user['email'] ?? '') ?>">
        </label>
        <div class="two-col">
            <label>
                <span>City</span>
                <input type="text" value="<?= e($user['city'] ?? '') ?>">
            </label>
            <label>
                <span>Country</span>
                <input type="text" value="<?= e($user['country'] ?? '') ?>">
            </label>
        </div>
        <label>
            <span>Language</span>
            <select>
                <option><?= e($user['language'] ?? 'English') ?></option>
                <option>Hindi</option>
                <option>Gujarati</option>
            </select>
        </label>
        <button class="button primary" type="button">Save profile</button>
        <button class="button danger" type="button">Delete account</button>
    </form>

    <div class="profile-side">
        <section>
            <h2>Preplanned trips</h2>
            <div class="mini-grid three">
                <?php foreach (array_slice($trips, 0, 3) as $trip): ?>
                    <article class="mini-card">
                        <img src="<?= asset($trip['cover_photo']) ?>" alt="">
                        <h3><?= e($trip['name']) ?></h3>
                        <a class="button small" href="<?= url('/trips/' . $trip['id']) ?>">View</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
        <section>
            <h2>Saved destinations</h2>
            <div class="chip-list">
                <?php foreach (array_slice($cities, 0, 4) as $city): ?>
                    <span><?= e($city['name']) ?></span>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</section>
