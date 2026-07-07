<?php $__env->startSection('title', $dealer->name); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-building me-2"></i><?php echo e($dealer->name); ?></h4>
    <div>
        <a href="<?php echo e(route('dealer-transactions.create')); ?>?dealer_id=<?php echo e($dealer->id); ?>" class="btn btn-success btn-sm">
            <i class="bi bi-plus"></i> New Purchase
        </a>
        <a href="<?php echo e(route('dealers.edit', $dealer)); ?>" class="btn btn-outline-secondary btn-sm">Edit</a>
        <a href="<?php echo e(route('dealers.index')); ?>" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted mb-3">Dealer Info</h6>
                <p class="mb-1"><i class="bi bi-phone me-2"></i><?php echo e($dealer->phone ?? 'N/A'); ?></p>
                <p class="mb-1"><i class="bi bi-geo-alt me-2"></i><?php echo e($dealer->address ?? 'N/A'); ?></p>
                <p class="mb-1"><i class="bi bi-file-text me-2"></i>GST: <?php echo e($dealer->gst_number ?? 'N/A'); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-<?php echo e($dealer->total_due > 0 ? 'danger' : 'success'); ?>">
            <div class="card-body text-center">
                <p class="text-muted mb-1">Outstanding Balance</p>
                <h2 class="<?php echo e($dealer->total_due > 0 ? 'text-danger' : 'text-success'); ?>">
                    ₹<?php echo e(number_format($dealer->total_due, 2)); ?>

                </h2>
                <small class="text-muted">Amount owed to dealer</small>
            </div>
        </div>
    </div>
</div>

<h6 class="mb-2">Transaction History</h6>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Items</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Paid</th>
                    <th class="text-end">Due</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $txn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($txn->date->format('d M Y')); ?></td>
                    <td><span class="badge bg-<?php echo e($txn->type === 'purchase' ? 'primary' : 'info'); ?>"><?php echo e(ucfirst($txn->type)); ?></span></td>
                    <td><?php echo e($txn->stockItems->count()); ?> units</td>
                    <td class="text-end">₹<?php echo e(number_format($txn->total_amount, 0)); ?></td>
                    <td class="text-end">₹<?php echo e(number_format($txn->paid_amount, 0)); ?></td>
                    <td class="text-end <?php echo e($txn->due_amount > 0 ? 'text-danger fw-bold' : 'text-success'); ?>">
                        ₹<?php echo e(number_format($txn->due_amount, 0)); ?>

                    </td>
                    <td><a href="<?php echo e(route('dealer-transactions.show', $txn)); ?>" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center text-muted py-3">No transactions yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($transactions->hasPages()): ?>
    <div class="card-footer"><?php echo e($transactions->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/dealers/show.blade.php ENDPATH**/ ?>