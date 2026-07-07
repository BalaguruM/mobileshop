<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">IMEI 1 <span class="text-danger">*</span></label>
        <input type="text" name="imei1" class="form-control <?php $__errorArgs = ['imei1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               value="<?php echo e(old('imei1', $stock->imei1 ?? '')); ?>" required maxlength="20">
        <?php $__errorArgs = ['imei1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="col-md-6">
        <label class="form-label">IMEI 2 (Dual SIM)</label>
        <input type="text" name="imei2" class="form-control" value="<?php echo e(old('imei2', $stock->imei2 ?? '')); ?>" maxlength="20">
    </div>
    <div class="col-md-4">
        <label class="form-label">Brand <span class="text-danger">*</span></label>
        <input type="text" name="brand" class="form-control <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               value="<?php echo e(old('brand', $stock->brand ?? '')); ?>" required>
        <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="col-md-4">
        <label class="form-label">Model <span class="text-danger">*</span></label>
        <input type="text" name="model" class="form-control <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               value="<?php echo e(old('model', $stock->model ?? '')); ?>" required>
        <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="col-md-4">
        <label class="form-label">Variant (RAM/Storage)</label>
        <input type="text" name="variant" class="form-control" placeholder="e.g. 8GB/128GB"
               value="<?php echo e(old('variant', $stock->variant ?? '')); ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">Color</label>
        <input type="text" name="color" class="form-control" value="<?php echo e(old('color', $stock->color ?? '')); ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">Dealer</label>
        <select name="dealer_id" class="form-select">
            <option value="">— Select Dealer —</option>
            <?php $__currentLoopData = $dealers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($d->id); ?>" <?php echo e(old('dealer_id', $stock->dealer_id ?? '') == $d->id ? 'selected' : ''); ?>>
                <?php echo e($d->name); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Date Added <span class="text-danger">*</span></label>
        <input type="date" name="date_added" class="form-control"
               value="<?php echo e(old('date_added', isset($stock) ? $stock->date_added->format('Y-m-d') : date('Y-m-d'))); ?>" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Cost Price (₹) <span class="text-danger">*</span></label>
        <input type="number" name="cost_price" class="form-control <?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               step="0.01" min="0" value="<?php echo e(old('cost_price', $stock->cost_price ?? '')); ?>" required>
        <?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="col-md-4">
        <label class="form-label">Selling Price (₹) <span class="text-danger">*</span></label>
        <input type="number" name="selling_price" class="form-control <?php $__errorArgs = ['selling_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               step="0.01" min="0" value="<?php echo e(old('selling_price', $stock->selling_price ?? '')); ?>" required>
        <?php $__errorArgs = ['selling_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="col-md-4">
        <label class="form-label">Warranty Period</label>
        <input type="text" name="warranty_period" class="form-control" placeholder="e.g. 1 year"
               value="<?php echo e(old('warranty_period', $stock->warranty_period ?? '')); ?>">
    </div>
    <div class="col-12">
        <label class="form-label">Box Contents</label>
        <input type="text" name="box_contents" class="form-control" placeholder="Charger, Cable, Earphones..."
               value="<?php echo e(old('box_contents', $stock->box_contents ?? '')); ?>">
    </div>
</div>
<?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/stock/_form.blade.php ENDPATH**/ ?>