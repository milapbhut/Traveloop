<?php
$subtotal = array_sum(array_map(fn (array $item): float => (float) $item['estimated_cost'], $expenses));
$actual = array_sum(array_map(fn (array $item): float => (float) ($item['actual_cost'] ?? $item['estimated_cost']), $expenses));
$balance = $actual - $subtotal;
?>
<section class="page-head">
    <div>
        <p class="eyebrow">Expense Invoice / Billing Screen</p>
        <h1><?= e($trip['name']) ?> invoice</h1>
        <p>Exportable cost sheet for planned and actual trip expenses.</p>
    </div>
    <div class="button-row">
        <button class="button secondary" type="button">Export as PDF</button>
        <button class="button primary" type="button">Attach to trip</button>
    </div>
</section>

<section class="invoice-paper">
    <div class="invoice-head">
        <div>
            <h2>Traveloop Invoice</h2>
            <p><?= e(date_range($trip['start_date'], $trip['end_date'])) ?></p>
        </div>
        <div>
            <span>Invoice ID</span>
            <strong>TRV-<?= e((string) $trip['id']) ?>-2026</strong>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Description</th>
                <th>Vendor</th>
                <th>Estimated</th>
                <th>Actual</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $index => $expense): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= e($expense['category']) ?></td>
                    <td><?= e($expense['description']) ?></td>
                    <td><?= e($expense['vendor'] ?? 'Pending') ?></td>
                    <td><?= money($expense['estimated_cost']) ?></td>
                    <td><?= money($expense['actual_cost'] ?? $expense['estimated_cost']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="invoice-total">
        <span>Subtotal planned: <?= money($subtotal) ?></span>
        <span>Actual spend: <?= money($actual) ?></span>
        <strong>Balance: <?= money($balance) ?></strong>
    </div>
</section>
