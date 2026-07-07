<?php $__env->startSection('title', 'Dealers'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-building me-2"></i>Dealers</h4>
    <a href="<?php echo e(route('dealers.create')); ?>" class="btn btn-primary"><i class="bi bi-plus"></i> Add Dealer</a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2" method="GET">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name or phone" value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-secondary">Search</button>
                <a href="<?php echo e(route('dealers.index')); ?>" class="btn btn-sm btn-link">Clear</a>
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
                    <th>GST</th>
                    <th class="text-end">Total Due (₹)</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $dealers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dealer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><a href="<?php echo e(route('dealers.show', $dealer)); ?>" class="text-decoration-none fw-semibold"><?php echo e($dealer->name); ?></a></td>
                    <td><?php echo e($dealer->phone ?? '—'); ?></td>
                    <td><small><?php echo e($dealer->gst_number ?? '—'); ?></small></td>
                    <td class="text-end <?php echo e($dealer->total_due > 0 ? 'text-danger fw-bold' : ''); ?>">
                        <?php echo e(number_format($dealer->total_due, 2)); ?>

                    </td>
                    <td><span class="badge <?php echo e($dealer->is_active ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e($dealer->is_active ? 'Active' : 'Inactive'); ?></span></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('dealers.edit', $dealer)); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('dealers.destroy', $dealer)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this dealer?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No dealers found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($dealers->hasPages()): ?>
    <div class="card-footer"><?php echo e($dealers->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/dealers/index.blade.php ENDPATH**/ ?>