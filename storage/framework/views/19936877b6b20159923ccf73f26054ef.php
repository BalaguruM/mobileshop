<?php $__env->startSection('title', 'Purchases from Dealers'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-arrow-down-circle me-2"></i>Purchases from Dealers</h4>
    <a href="<?php echo e(route('dealer-transactions.create')); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> New Purchase</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2" method="GET">
            <div class="col-md-3">
                <select name="dealer_id" class="form-select form-select-sm">
                    <option value="">All Dealers</option>
                    <?php $__currentLoopData = $dealers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($d->id); ?>" <?php echo e(request('dealer_id')==$d->id?'selected':''); ?>><?php echo e($d->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <div class="form-check mt-1">
                    <input type="checkbox" name="dues_only" value="1" class="form-check-input" id="dues_only" <?php echo e(request('dues_only')?'checked':''); ?>>
                    <label class="form-check-label" for="dues_only">Pending dues only</label>
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary">Filter</button>
                <a href="<?php echo e(route('dealer-transactions.index')); ?>" class="btn btn-sm btn-link">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Dealer</th>
                    <th>Type</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Paid</th>
                    <th class="text-end">Due</th>
                    <th>Due Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $txn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><small>#<?php echo e($txn->id); ?></small></td>
                    <td><?php echo e($txn->date->format('d M Y')); ?></td>
                    <td><a href="<?php echo e(route('dealers.show', $txn->dealer)); ?>" class="text-decoration-none"><?php echo e($txn->dealer->name); ?></a></td>
                    <td><span class="badge bg-<?php echo e($txn->type==='purchase'?'primary':'info'); ?>"><?php echo e(ucfirst($txn->type)); ?></span></td>
                    <td class="text-end">₹<?php echo e(number_format($txn->total_amount, 0)); ?></td>
                    <td class="text-end">₹<?php echo e(number_format($txn->paid_amount, 0)); ?></td>
                    <td class="text-end <?php echo e($txn->due_amount > 0 ? 'text-danger fw-bold' : 'text-success'); ?>">
                        ₹<?php echo e(number_format($txn->due_amount, 0)); ?>

                    </td>
                    <td>
                        <?php if($txn->due_date): ?>
                            <span class="<?php echo e($txn->due_date->isPast() && $txn->due_amount > 0 ? 'text-danger' : ''); ?>">
                                <?php echo e($txn->due_date->format('d M Y')); ?>

                            </span>
                        <?php else: ?> —
                        <?php endif; ?>
                    </td>
                    <td><a href="<?php echo e(route('dealer-transactions.show', $txn)); ?>" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" class="text-center text-muted py-4">No transactions found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($transactions->hasPages()): ?>
    <div class="card-footer"><?php echo e($transactions->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/dealer-transactions/index.blade.php ENDPATH**/ ?>