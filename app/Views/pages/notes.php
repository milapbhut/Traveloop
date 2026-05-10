<section class="page-head">
    <div>
        <p class="eyebrow">Trip Notes / Journal Screen</p>
        <h1><?= e($trip['name']) ?> notes</h1>
        <p>Save hotel details, local contacts, and day-specific reminders.</p>
    </div>
</section>

<section class="notes-layout">
    <form class="panel-form compact" action="<?= url('/trips/' . $trip['id'] . '/notes') ?>" method="post">
        <h2>New trip note</h2>
        <label>
            <span>Title</span>
            <input type="text" name="title" placeholder="Hotel check-in details">
        </label>
        <label>
            <span>Date</span>
            <input type="date" name="note_date" value="<?= e(date('Y-m-d')) ?>">
        </label>
        <label>
            <span>Note</span>
            <textarea name="body" rows="6" placeholder="Write reminders, contacts, confirmation numbers"></textarea>
        </label>
        <button class="button primary" type="submit">Save note</button>
    </form>

    <div class="note-list">
        <?php foreach ($notes as $note): ?>
            <article class="note-card">
                <div>
                    <span><?= e(pretty_date($note['note_date'])) ?></span>
                    <h2><?= e($note['title']) ?></h2>
                </div>
                <p><?= e($note['body']) ?></p>
                <small>Saved <?= e($note['created_at'] ?? 'just now') ?></small>
            </article>
        <?php endforeach; ?>
    </div>
</section>
