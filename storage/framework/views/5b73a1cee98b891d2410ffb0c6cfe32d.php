<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
    <span class="text-muted"><?php echo e(now()->format('d M Y')); ?></span>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-primary h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">In Stock</p>
                        <h3 class="mb-0 text-primary"><?php echo e($stats['total_stock']); ?></h3>
                    </div>
                    <i class="bi bi-box-seam text-primary fs-2 opacity-50"></i>
                </div>
                <small class="text-muted">Stock value: ₹<?php echo e(number_format($stats['stock_value'], 0)); ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Today Sales</p>
                        <h3 class="mb-0 text-success">₹<?php echo e(number_format($stats['today_sales'], 0)); ?></h3>
                    </div>
                    <i class="bi bi-cart-check text-success fs-2 opacity-50"></i>
                </div>
                <small class="text-muted"><?php echo e($stats['today_sales_count']); ?> transactions</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Customer Dues</p>
                        <h3 class="mb-0 text-warning">₹<?php echo e(number_format($stats['customer_dues'], 0)); ?></h3>
                    </div>
                    <i class="bi bi-person-exclamation text-warning fs-2 opacity-50"></i>
                </div>
                <small class="text-muted">Receivables</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-danger h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Dealer Dues</p>
                        <h3 class="mb-0 text-danger">₹<?php echo e(number_format($stats['dealer_dues'], 0)); ?></h3>
                    </div>
                    <i class="bi bi-building-exclamation text-danger fs-2 opacity-50"></i>
                </div>
                <small class="text-muted">Payables</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Recent Sales -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-cart me-2"></i>Recent Sales</span>
                <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recent_sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-3">
                                <div><?php echo e($sale->customer_label); ?></div>
                                <small class="text-muted"><?php echo e($sale->date->format('d M')); ?></small>
                            </td>
                            <td class="text-end pe-3">
                                <div>₹<?php echo e(number_format($sale->total_amount, 0)); ?></div>
                                <?php if($sale->due_amount > 0): ?>
                                    <span class="badge bg-warning text-dark">Due: ₹<?php echo e(number_format($sale->due_amount, 0)); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="2" class="text-center text-muted py-3">No sales yet</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Customer Dues -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-people me-2"></i>Top Customer Dues</span>
                <a href="<?php echo e(route('customers.index', ['dues_only' => 1])); ?>" class="btn btn-sm btn-outline-warning">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $overdue_customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-3">
                                <a href="<?php echo e(route('customers.show', $c)); ?>" class="text-decoration-none"><?php echo e($c->name); ?></a>
                                <div><small class="text-muted"><?php echo e($c->phone); ?></small></div>
                            </td>
                            <td class="text-end pe-3 text-danger fw-bold">₹<?php echo e(number_format($c->total_due, 0)); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="2" class="text-center text-muted py-3">No pending dues</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Low Stock -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header"><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Low Stock Alert</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $low_stock_models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-3">
                                <div class="small"><?php echo e($m->brand); ?> <?php echo e($m->model); ?></div>
                            </td>
                            <td class="text-end pe-3">
                                <span class="badge <?php echo e($m->count == 0 ? 'bg-danger' : 'bg-warning text-dark'); ?>"><?php echo e($m->count); ?></span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="2" class="text-center text-muted py-3">Stock levels OK</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/dashboard.blade.php ENDPATH**/ ?>