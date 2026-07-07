<?php $__env->startSection('title', 'Add Customer'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-person-plus me-2"></i>Add Customer</h4>
    <a href="<?php echo e(route('customers.index')); ?>" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>
<div class="card" style="max-width:600px">
    <div class="card-body">
        <form action="<?php echo e(route('customers.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('customers._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <button class="btn btn-primary mt-3">Save Customer</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/customers/create.blade.php ENDPATH**/ ?>