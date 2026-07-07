<?php $__env->startSection('title', 'Add Dealer'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-building-add me-2"></i>Add Dealer</h4>
    <a href="<?php echo e(route('dealers.index')); ?>" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>

<div class="card" style="max-width:600px">
    <div class="card-body">
        <form action="<?php echo e(route('dealers.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('dealers._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <button class="btn btn-primary mt-3">Save Dealer</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/dealers/create.blade.php ENDPATH**/ ?>