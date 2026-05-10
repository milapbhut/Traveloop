<?php
$title = $title ?? 'Traveloop';
$page = $page ?? '';
$minimal = $minimal ?? false;
$user = $user ?? [];
$dbConnected = $dbConnected ?? false;
$flashSuccess = flash('success');
$flashError = flash('error');
$primaryTripId = 1;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> | Traveloop</title>
    <link rel="stylesheet" href="<?= asset('assets/css/app.css') ?>">
</head>
<body class="<?= $minimal ? 'auth-body' : 'app-body' ?>">
    <header class="topbar">
        <a class="brand" href="<?= url('/dashboard') ?>" aria-label="Traveloop home">
            <span class="brand-mark">T</span>
            <span>Traveloop</span>
        </a>

        <?php if (!$minimal): ?>
            <form class="global-search" action="<?= url('/search/cities') ?>" method="get">
                <input type="search" name="q" placeholder="Search cities, activities, trips">
                <button type="submit" title="Search">Search</button>
            </form>
            <div class="topbar-actions">
                <span class="db-pill <?= $dbConnected ? 'is-live' : '' ?>"><?= $dbConnected ? 'MySQL live' : 'Demo data' ?></span>
                <a class="icon-link" href="<?= url('/profile') ?>" title="Profile"><?= e(substr($user['name'] ?? 'U', 0, 1)) ?></a>
            </div>
        <?php else: ?>
            <nav class="auth-links" aria-label="Account">
                <a href="<?= url('/login') ?>">Login</a>
                <a href="<?= url('/register') ?>">Sign up</a>
            </nav>
        <?php endif; ?>
    </header>

    <?php if ($minimal): ?>
        <main class="auth-shell">
            <?php if ($flashSuccess): ?><div class="flash success"><?= e($flashSuccess) ?></div><?php endif; ?>
            <?php if ($flashError): ?><div class="flash error"><?= e($flashError) ?></div><?php endif; ?>
            <?= $content ?>
        </main>
    <?php else: ?>
        <div class="layout">
            <aside class="sidebar" aria-label="Primary">
                <nav class="side-nav">
                    <a class="<?= active_class('dashboard', $page) ?>" href="<?= url('/dashboard') ?>">Dashboard</a>
                    <a class="<?= active_class('trips', $page) ?>" href="<?= url('/trips') ?>">My Trips</a>
                    <a class="<?= active_class('create', $page) ?>" href="<?= url('/trips/create') ?>">Create Trip</a>
                    <a class="<?= active_class('builder', $page) ?>" href="<?= url('/trips/' . $primaryTripId . '/builder') ?>">Builder</a>
                    <a class="<?= active_class('itinerary', $page) ?>" href="<?= url('/trips/' . $primaryTripId) ?>">Itinerary</a>
                    <a class="<?= active_class('budget', $page) ?>" href="<?= url('/trips/' . $primaryTripId . '/budget') ?>">Budget</a>
                    <a class="<?= active_class('checklist', $page) ?>" href="<?= url('/trips/' . $primaryTripId . '/checklist') ?>">Checklist</a>
                    <a class="<?= active_class('notes', $page) ?>" href="<?= url('/trips/' . $primaryTripId . '/notes') ?>">Notes</a>
                    <a class="<?= active_class('search', $page) ?>" href="<?= url('/search/cities') ?>">Search</a>
                    <a class="<?= active_class('community', $page) ?>" href="<?= url('/community') ?>">Community</a>
                    <a class="<?= active_class('admin', $page) ?>" href="<?= url('/admin') ?>">Admin</a>
                </nav>
            </aside>

            <main class="content">
                <?php if ($flashSuccess): ?><div class="flash success"><?= e($flashSuccess) ?></div><?php endif; ?>
                <?php if ($flashError): ?><div class="flash error"><?= e($flashError) ?></div><?php endif; ?>
                <?= $content ?>
            </main>
        </div>
    <?php endif; ?>

    <script src="<?= asset('assets/js/app.js') ?>" defer></script>
</body>
</html>
