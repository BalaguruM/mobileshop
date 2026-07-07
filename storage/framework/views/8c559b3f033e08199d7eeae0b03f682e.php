<?php $__env->startSection('title', 'Purchase #' . $dealerTransaction->id); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Purchase #<?php echo e($dealerTransaction->id); ?> — <?php echo e($dealerTransaction->dealer->name); ?></h4>
    <a href="<?php echo e(route('dealer-transactions.index')); ?>" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th>Type</th><td><span class="badge bg-primary"><?php echo e(ucfirst($dealerTransaction->type)); ?></span></td></tr>
                    <tr><th>Date</th><td><?php echo e($dealerTransaction->date->format('d M Y')); ?></td></tr>
                    <tr><th>Due Date</th><td><?php echo e($dealerTransaction->due_date?->format('d M Y') ?? '—'); ?></td></tr>
                    <tr><th>Total</th><td>₹<?php echo e(number_format($dealerTransaction->total_amount, 2)); ?></td></tr>
                    <tr><th>Paid</th><td>₹<?php echo e(number_format($dealerTransaction->paid_amount, 2)); ?></td></tr>
                    <tr><th>Due</th><td class="<?php echo e($dealerTransaction->due_amount > 0 ? 'text-danger fw-bold' : 'text-success'); ?>">₹<?php echo e(number_format($dealerTransaction->due_amount, 2)); ?></td></tr>
                </table>
            </div>
        </div>
    </div>

    <?php if($dealerTransaction->due_amount > 0): ?>
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-header">Record Payment</div>
            <div class="card-body">
                <form action="<?php echo e(route('dealer-transactions.pay', $dealerTransaction)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-2">
                        <label class="form-label form-label-sm">Amount (₹)</label>
                        <input type="number" name="amount" class="form-control form-control-sm" step="0.01" min="0.01"
                               max="<?php echo e($dealerTransaction->due_amount); ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label form-label-sm">Mode</label>
                        <select name="mode" class="form-select form-select-sm">
                            <option value="cash">Cash</option>
                            <option value="upi">UPI</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Card</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label form-label-sm">Date</label>
                        <input type="date" name="date" class="form-control form-control-sm" value="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label form-label-sm">Notes</label>
                        <input type="text" name="notes" class="form-control form-control-sm">
                    </div>
                    <button class="btn btn-warning btn-sm w-100">Pay Dealer</button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Items Table -->
<h6 class="mb-2">Items in this Purchase</h6>
<div class="card mb-3">
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>IMEI</th>
                    <th>Brand / Model</th>
                    <th>Variant</th>
                    <th>Color</th>
                    <th class="text-end">Cost</th>
                    <th>Status</th>
                    <th>Return</th>
                </tr>
            </thead>
            <tbody>
                <?php $colors = ['in_stock'=>'success','sold'=>'secondary','returned'=>'info','damaged'=>'danger'] ?>
                <?php $__currentLoopData = $dealerTransaction->stockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="font-monospace"><?php echo e($item->imei1); ?></td>
                    <td><?php echo e($item->brand); ?> <?php echo e($item->model); ?></td>
                    <td><?php echo e($item->variant); ?></td>
                    <td><?php echo e($item->color); ?></td>
                    <td class="text-end">₹<?php echo e(number_format($item->cost_price, 0)); ?></td>
                    <td><span class="badge bg-<?php echo e($colors[$item->status]); ?>"><?php echo e(str_replace('_',' ',ucfirst($item->status))); ?></span></td>
                    <td>
                        <?php if($item->status === 'in_stock'): ?>
                        <form action="<?php echo e(route('dealer-transactions.return', $dealerTransaction)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('Return this item to dealer?')">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="stock_item_ids[]" value="<?php echo e($item->id); ?>">
                            <button class="btn btn-xs btn-outline-info btn-sm">Return</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Payment History -->
<?php if($dealerTransaction->payments->count()): ?>
<h6 class="mb-2">Payment History</h6>
<div class="card">
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead class="table-light">
                <tr><th>Date</th><th>Amount</th><th>Mode</th><th>Notes</th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $dealerTransaction->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pmt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($pmt->date->format('d M Y')); ?></td>
                    <td>₹<?php echo e(number_format($pmt->amount, 2)); ?></td>
                    <td><?php echo e(ucfirst(str_replace('_',' ',$pmt->mode))); ?></td>
                    <td><?php echo e($pmt->notes ?? '—'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/dealer-transactions/show.blade.php ENDPATH**/ ?>