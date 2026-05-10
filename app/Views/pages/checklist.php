<?php
$grouped = [];
foreach ($items as $item) {
    $grouped[$item['category']][] = $item;
}
?>
<section class="page-head">
    <div>
        <p class="eyebrow">Packing Checklist Screen</p>
        <h1><?= e($trip['name']) ?> packing list</h1>
        <p>Add, check off, and reset items by category.</p>
    </div>
</section>

<section class="checklist-layout">
    <form class="panel-form compact" action="<?= url('/trips/' . $trip['id'] . '/checklist') ?>" method="post">
        <h2>Add checklist item</h2>
        <label>
            <span>Item</span>
            <input type="text" name="item" placeholder="Travel adapter">
        </label>
        <label>
            <span>Category</span>
            <select name="category">
                <option>Documents</option>
                <option>Clothing</option>
                <option>Electronics</option>
                <option>Health</option>
                <option>General</option>
            </select>
        </label>
        <button class="button primary" type="submit">Add item</button>
        <button class="button secondary" type="button">Reset checklist</button>
    </form>

    <div class="checklist-groups">
        <?php foreach ($grouped as $category => $categoryItems): ?>
            <section class="check-group">
                <h2><?= e($category) ?></h2>
                <?php foreach ($categoryItems as $item): ?>
                    <label class="check-row">
                        <input type="checkbox" <?= (int) $item['packed'] === 1 ? 'checked' : '' ?>>
                        <span><?= e($item['item']) ?></span>
                    </label>
                <?php endforeach; ?>
            </section>
        <?php endforeach; ?>
    </div>
</section>
