<?php $__env->startSection('title', 'Customers'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-people me-2"></i>Customers</h4>
    <a href="<?php echo e(route('customers.create')); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> Add Customer</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2" method="GET">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search name or phone" value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-auto">
                <div class="form-check mt-1">
                    <input type="checkbox" name="dues_only" value="1" class="form-check-input" id="dues_only" <?php echo e(request('dues_only') ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="dues_only">Dues only</label>
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary">Filter</button>
                <a href="<?php echo e(route('customers.index')); ?>" class="btn btn-sm btn-link">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>ID Proof</th>
                    <th class="text-end">Total Due (₹)</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><a href="<?php echo e(route('customers.show', $customer)); ?>" class="text-decoration-none fw-semibold"><?php echo e($customer->name); ?></a></td>
                    <td><?php echo e($customer->phone ?? '—'); ?></td>
                    <td><small><?php echo e($customer->id_proof ?? '—'); ?></small></td>
                    <td class="text-end <?php echo e($customer->total_due > 0 ? 'text-danger fw-bold' : ''); ?>">
                        <?php echo e(number_format($customer->total_due, 2)); ?>

                    </td>
                    <td class="text-end">
                        <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('customers.destroy', $customer)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this customer?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">No customers found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($customers->hasPages()): ?>
    <div class="card-footer"><?php echo e($customers->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/customers/index.blade.php ENDPATH**/ ?>