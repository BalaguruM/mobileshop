<?php $__env->startSection('title', 'Stock'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i>Stock Inventory</h4>
    <a href="<?php echo e(route('stock.create')); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> Add Item</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2" method="GET">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="IMEI / Brand / Model" value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="in_stock" <?php echo e(request('status')=='in_stock'?'selected':''); ?>>In Stock</option>
                    <option value="sold" <?php echo e(request('status')=='sold'?'selected':''); ?>>Sold</option>
                    <option value="returned" <?php echo e(request('status')=='returned'?'selected':''); ?>>Returned</option>
                    <option value="damaged" <?php echo e(request('status')=='damaged'?'selected':''); ?>>Damaged</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="brand" class="form-select form-select-sm">
                    <option value="">All Brands</option>
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($b); ?>" <?php echo e(request('brand')==$b?'selected':''); ?>><?php echo e($b); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary">Filter</button>
                <a href="<?php echo e(route('stock.index')); ?>" class="btn btn-sm btn-link">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>IMEI</th>
                    <th>Brand / Model</th>
                    <th>Variant</th>
                    <th>Color</th>
                    <th>Dealer</th>
                    <th class="text-end">Cost</th>
                    <th class="text-end">Selling</th>
                    <th>Status</th>
                    <th>Added</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><small class="font-monospace"><?php echo e($item->imei1); ?></small></td>
                    <td><?php echo e($item->brand); ?> <?php echo e($item->model); ?></td>
                    <td><small><?php echo e($item->variant); ?></small></td>
                    <td><small><?php echo e($item->color); ?></small></td>
                    <td><small><?php echo e($item->dealer->name ?? '—'); ?></small></td>
                    <td class="text-end">₹<?php echo e(number_format($item->cost_price, 0)); ?></td>
                    <td class="text-end">₹<?php echo e(number_format($item->selling_price, 0)); ?></td>
                    <td>
                        <?php $colors = ['in_stock'=>'success','sold'=>'secondary','returned'=>'info','damaged'=>'danger'] ?>
                        <span class="badge bg-<?php echo e($colors[$item->status]); ?>"><?php echo e(str_replace('_',' ',ucfirst($item->status))); ?></span>
                    </td>
                    <td><small><?php echo e($item->date_added->format('d M Y')); ?></small></td>
                    <td>
                        <a href="<?php echo e(route('stock.show', $item)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <?php if($item->status === 'in_stock'): ?>
                        <a href="<?php echo e(route('stock.edit', $item)); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="10" class="text-center text-muted py-4">No stock items found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($items->hasPages()): ?>
    <div class="card-footer"><?php echo e($items->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/stock/index.blade.php ENDPATH**/ ?>