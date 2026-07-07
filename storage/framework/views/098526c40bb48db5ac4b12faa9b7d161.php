<?php $__env->startSection('title', 'Stock Item'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><?php echo e($stock->brand); ?> <?php echo e($stock->model); ?></h4>
    <div>
        <?php if($stock->status === 'in_stock'): ?>
        <a href="<?php echo e(route('stock.edit', $stock)); ?>" class="btn btn-outline-secondary btn-sm">Edit</a>
        <?php endif; ?>
        <a href="<?php echo e(route('stock.index')); ?>" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Device Details</div>
            <div class="card-body">
                <?php $colors = ['in_stock'=>'success','sold'=>'secondary','returned'=>'info','damaged'=>'danger'] ?>
                <table class="table table-sm mb-0">
                    <tr><th>Status</th><td><span class="badge bg-<?php echo e($colors[$stock->status]); ?>"><?php echo e(str_replace('_',' ',ucfirst($stock->status))); ?></span></td></tr>
                    <tr><th>IMEI 1</th><td class="font-monospace"><?php echo e($stock->imei1); ?></td></tr>
                    <?php if($stock->imei2): ?><tr><th>IMEI 2</th><td class="font-monospace"><?php echo e($stock->imei2); ?></td></tr><?php endif; ?>
                    <tr><th>Brand</th><td><?php echo e($stock->brand); ?></td></tr>
                    <tr><th>Model</th><td><?php echo e($stock->model); ?></td></tr>
                    <tr><th>Variant</th><td><?php echo e($stock->variant ?? '—'); ?></td></tr>
                    <tr><th>Color</th><td><?php echo e($stock->color ?? '—'); ?></td></tr>
                    <tr><th>Cost Price</th><td>₹<?php echo e(number_format($stock->cost_price, 2)); ?></td></tr>
                    <tr><th>Selling Price</th><td>₹<?php echo e(number_format($stock->selling_price, 2)); ?></td></tr>
                    <tr><th>Date Added</th><td><?php echo e($stock->date_added->format('d M Y')); ?></td></tr>
                    <tr><th>Warranty</th><td><?php echo e($stock->warranty_period ?? '—'); ?></td></tr>
                    <tr><th>Box Contents</th><td><?php echo e($stock->box_contents ?? '—'); ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">Source</div>
            <div class="card-body">
                <?php if($stock->dealer): ?>
                <p class="mb-1"><strong>Dealer:</strong>
                    <a href="<?php echo e(route('dealers.show', $stock->dealer)); ?>"><?php echo e($stock->dealer->name); ?></a>
                </p>
                <?php endif; ?>
                <?php if($stock->dealerTransaction): ?>
                <p class="mb-1"><strong>Purchase Txn:</strong>
                    <a href="<?php echo e(route('dealer-transactions.show', $stock->dealerTransaction)); ?>">#<?php echo e($stock->dealerTransaction->id); ?></a>
                </p>
                <?php endif; ?>
            </div>
        </div>
        <?php if($stock->saleItem): ?>
        <div class="card">
            <div class="card-header">Sale Info</div>
            <div class="card-body">
                <?php $saleTxn = $stock->saleItem->saleTransaction ?>
                <p class="mb-1"><strong>Sale #<?php echo e($saleTxn->id); ?></strong></p>
                <p class="mb-1">Customer: <?php echo e($saleTxn->customer_label); ?></p>
                <p class="mb-1">Date: <?php echo e($saleTxn->date->format('d M Y')); ?></p>
                <p class="mb-1">Sold for: ₹<?php echo e(number_format($stock->saleItem->selling_price, 2)); ?></p>
                <a href="<?php echo e(route('sales.show', $saleTxn)); ?>" class="btn btn-sm btn-outline-primary mt-1">View Sale</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/stock/show.blade.php ENDPATH**/ ?>