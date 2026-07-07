<?php $__env->startSection('title', 'Sale #' . $sale->id); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Sale #<?php echo e($sale->id); ?> — <?php echo e($sale->customer_label); ?></h4>
    <div>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer me-1"></i>Print</button>
        <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th>Customer</th><td><?php echo e($sale->customer_label); ?></td></tr>
                    <?php if($sale->customer): ?>
                    <tr><th>Phone</th><td><?php echo e($sale->customer->phone ?? '—'); ?></td></tr>
                    <?php endif; ?>
                    <tr><th>Date</th><td><?php echo e($sale->date->format('d M Y')); ?></td></tr>
                    <tr><th>Payment Mode</th><td><?php echo e(ucfirst($sale->payment_mode)); ?></td></tr>
                    <tr><th>Discount</th><td>₹<?php echo e(number_format($sale->discount, 2)); ?></td></tr>
                    <tr><th>Total</th><td><strong>₹<?php echo e(number_format($sale->total_amount, 2)); ?></strong></td></tr>
                    <tr><th>Paid</th><td class="text-success">₹<?php echo e(number_format($sale->paid_amount, 2)); ?></td></tr>
                    <tr><th>Due</th><td class="<?php echo e($sale->due_amount > 0 ? 'text-danger fw-bold' : 'text-success'); ?>">₹<?php echo e(number_format($sale->due_amount, 2)); ?></td></tr>
                    <?php if($sale->due_date): ?>
                    <tr><th>Due Date</th><td><?php echo e($sale->due_date->format('d M Y')); ?></td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

    <?php if($sale->due_amount > 0): ?>
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-header">Collect Payment</div>
            <div class="card-body">
                <form action="<?php echo e(route('sales.pay', $sale)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-2">
                        <label class="form-label form-label-sm">Amount (₹)</label>
                        <input type="number" name="amount" class="form-control form-control-sm" step="0.01" min="0.01"
                               max="<?php echo e($sale->due_amount); ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label form-label-sm">Mode</label>
                        <select name="mode" class="form-select form-select-sm">
                            <option value="cash">Cash</option>
                            <option value="upi">UPI</option>
                            <option value="card">Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
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
                    <button class="btn btn-warning btn-sm w-100">Collect Payment</button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Items Sold -->
<h6 class="mb-2">Items Sold</h6>
<div class="card mb-3">
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead class="table-light">
                <tr><th>IMEI</th><th>Brand / Model</th><th>Variant</th><th>Color</th><th class="text-end">Price</th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $sale->saleItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $si): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="font-monospace"><?php echo e($si->stockItem->imei1); ?></td>
                    <td><?php echo e($si->stockItem->brand); ?> <?php echo e($si->stockItem->model); ?></td>
                    <td><?php echo e($si->stockItem->variant); ?></td>
                    <td><?php echo e($si->stockItem->color); ?></td>
                    <td class="text-end">₹<?php echo e(number_format($si->selling_price, 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($sale->discount > 0): ?>
                <tr class="table-light">
                    <td colspan="4" class="text-end text-muted">Discount</td>
                    <td class="text-end text-success">— ₹<?php echo e(number_format($sale->discount, 2)); ?></td>
                </tr>
                <?php endif; ?>
                <tr class="table-light fw-bold">
                    <td colspan="4" class="text-end">Total</td>
                    <td class="text-end">₹<?php echo e(number_format($sale->total_amount, 2)); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Payment History -->
<?php if($sale->payments->count()): ?>
<h6 class="mb-2">Payment History</h6>
<div class="card">
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead class="table-light">
                <tr><th>Date</th><th>Amount</th><th>Mode</th><th>Notes</th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $sale->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pmt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/sales/show.blade.php ENDPATH**/ ?>