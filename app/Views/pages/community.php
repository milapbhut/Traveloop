<section class="page-head">
    <div>
        <p class="eyebrow">Community Tab Screen</p>
        <h1>Community trip ideas</h1>
        <p>Public plans and notes shared by other travelers.</p>
    </div>
    <a class="button primary" href="<?= url('/share/west-loop') ?>">View public page</a>
</section>

<section class="community-feed">
    <?php foreach ($posts as $post): ?>
        <article class="community-post">
            <div class="post-avatar"><?= e(substr($post['author'], 0, 1)) ?></div>
            <div>
                <span><?= e($post['author']) ?> - <?= e($post['trip_name']) ?></span>
                <h2><?= e($post['title']) ?></h2>
                <p><?= e($post['body']) ?></p>
                <small><?= e($post['likes']) ?> saves - <?= e(pretty_date($post['created_at'])) ?></small>
            </div>
        </article>
    <?php endforeach; ?>
</section>
