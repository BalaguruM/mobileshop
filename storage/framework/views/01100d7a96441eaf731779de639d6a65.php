<?php $__env->startSection('title', 'New Sale'); ?>

<?php $__env->startSection('content'); ?>
<style>

.toggleWrapper {
    margin-top: -1px;
}

.toggleWrapper input.mobileToggle {
    opacity: 0;
    position: absolute;
}

.toggleWrapper input.mobileToggle+label {
    position: relative;
    display: inline-block;
    user-select: none;
    -moz-transition: 0.4s ease;
    -o-transition: 0.4s ease;
    -webkit-transition: 0.4s ease;
    transition: 0.4s ease;
    -webkit-tap-highlight-color: transparent;
    height: 26px;
    width: 49px;
    border: 1px solid #e4e4e4;
    border-radius: 60px;
}

.toggleWrapper input.mobileToggle+label:before {
    content: "";
    position: absolute;
    display: block;
    -moz-transition: 0.2s cubic-bezier(0.24, 0, 0.5, 1);
    -o-transition: 0.2s cubic-bezier(0.24, 0, 0.5, 1);
    -webkit-transition: 0.2s cubic-bezier(0.24, 0, 0.5, 1);
    transition: 0.2s cubic-bezier(0.24, 0, 0.5, 1);
    height: 26px;
    width: 49px;
    top: -1px;
    left: 0;
    border-radius: 30px;
}

.toggleWrapper input.mobileToggle+label:after {
    content: "";
    position: absolute;
    display: block;
    box-shadow: 0 0 0 1px hsla(0, 0%, 0%, 0.1), 0 4px 0px 0 hsla(0, 0%, 0%, 0.04), 0 4px 9px hsla(0, 0%, 0%, 0.13), 0 3px 3px hsla(0, 0%, 0%, 0.05);
    -moz-transition: 0.35s cubic-bezier(0.54, 1.6, 0.5, 1);
    -o-transition: 0.35s cubic-bezier(0.54, 1.6, 0.5, 1);
    -webkit-transition: 0.35s cubic-bezier(0.54, 1.6, 0.5, 1);
    transition: 0.35s cubic-bezier(0.54, 1.6, 0.5, 1);
    background: whitesmoke;
    height: 24px;
    width: 24px;
    top: 0px;
    left: 0px;
    border-radius: 60px;
}

.toggleWrapper input.mobileToggle:checked+label:before {
    background: #2ecc71;
    -moz-transition: width 0.2s cubic-bezier(0, 0, 0, 0.1);
    -o-transition: width 0.2s cubic-bezier(0, 0, 0, 0.1);
    -webkit-transition: width 0.2s cubic-bezier(0, 0, 0, 0.1);
    transition: width 0.2s cubic-bezier(0, 0, 0, 0.1);
}

.toggleWrapper input.mobileToggle:checked+label:after {
    left: 24px;
}
    </style>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="bi bi-cart-plus me-2"></i>New Sale</h4>
        <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>

    <form action="<?php echo e(route('sales.store')); ?>" method="POST" id="saleForm">
        <?php echo csrf_field(); ?>
        <div class="row g-3">
            <!-- Left: Customer & Payment -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Customer</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" id="ct_existing"
                                    value="existing" <?php echo e(old('customer_type', 'existing') == 'existing' ? 'checked' : ''); ?>

                                    onchange="toggleCustomer()">
                                <label class="form-check-label" for="ct_existing">Existing</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" id="ct_walkin"
                                    value="walkin" <?php echo e(old('customer_type') == 'walkin' ? 'checked' : ''); ?>

                                    onchange="toggleCustomer()">
                                <label class="form-check-label" for="ct_walkin">Walk-in</label>
                            </div>
                        </div>
                        <div id="existingCustomer">
                            <select name="customer_id" class="form-select form-select-sm">
                                <option value="">— Select Customer —</option>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->id); ?>"
                                        <?php echo e(request('customer_id') == $c->id || old('customer_id') == $c->id ? 'selected' : ''); ?>>
                                        <?php echo e($c->name); ?> <?php echo e($c->phone ? '(' . $c->phone . ')' : ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div id="walkinCustomer" style="display:none">
                            <input type="text" name="customer_name_override" class="form-control form-control-sm"
                                placeholder="Customer name (optional)" value="<?php echo e(old('customer_name_override')); ?>">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Payment</div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label form-label-sm">Mode <span class="text-danger">*</span></label>
                            <select name="payment_mode" class="form-select form-select-sm" required>
                                <option value="cash" <?php echo e(old('payment_mode') == 'cash' ? 'selected' : ''); ?>>Cash</option>
                                <option value="upi" <?php echo e(old('payment_mode') == 'upi' ? 'selected' : ''); ?>>UPI</option>
                                <option value="card" <?php echo e(old('payment_mode') == 'card' ? 'selected' : ''); ?>>Card</option>
                                <option value="credit" <?php echo e(old('payment_mode') == 'credit' ? 'selected' : ''); ?>>Credit / Due
                                </option>
                                <option value="emi" <?php echo e(old('payment_mode') == 'emi' ? 'selected' : ''); ?>>EMI</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label form-label-sm">Invoice Type (GST)<span class="text-danger">*</span></label>
                            <div class="float-right toggleWrapper" style="float:right;">
                                <input type="checkbox" data-typeid="1" id="gst" name="gst"
                                    value="1" class="mobileToggle">
                                <label for="gst"></label>
                            </div>
                        </div>

                        <div class="mb-2" style="display: none;">
                            <label class="form-label form-label-sm">GST Rates</label>
                            <select name="gst_value" class="form-select form-select-sm" required>
                                <option value="cash" <?php echo e(old('payment_mode') == 'cash' ? 'selected' : ''); ?>>Cash</option>
                                <option value="18" <?php echo e(old('gst_value') == 18 ? 'selected' : ''); ?>>18%(mobiles)</option>
                                <option value="28" <?php echo e(old('gst_value') == 28 ? 'selected' : ''); ?>>28%</option>
                                <option value="12" <?php echo e(old('gst_value') == 12 ? 'selected' : ''); ?>>12%
                                </option>
                                <option value="0" <?php echo e(old('gst_value') == 0 ? 'selected' : ''); ?>>0%</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label form-label-sm">Discount (₹)</label>
                            <input type="number" name="discount" id="discountInput" class="form-control form-control-sm"
                                step="0.01" min="0" value="<?php echo e(old('discount', 0)); ?>" oninput="calcSaleTotal()">
                        </div>
                        <div class="mb-2">
                            <label class="form-label form-label-sm">Amount Paid (₹)</label>
                            <input type="number" name="paid_amount" class="form-control form-control-sm" step="0.01"
                                min="0" value="<?php echo e(old('paid_amount', 0)); ?>" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label form-label-sm">Due Date</label>
                            <input type="date" name="due_date" class="form-control form-control-sm"
                                value="<?php echo e(old('due_date')); ?>">
                        </div>
                        <div class="mb-2">
                            <label class="form-label form-label-sm">Notes</label>
                            <textarea name="notes" class="form-control form-control-sm" rows="2"></textarea>
                        </div>
                        <div class="alert alert-light p-2 mb-0 small">
                            Items Total: <strong id="itemsTotal">₹0</strong><br>
                            After Discount: <strong id="netTotal">₹0</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Stock Selection -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Select Items to Sell</div>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0" id="stockTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="40"></th>
                                    <th>IMEI</th>
                                    <th>Brand / Model</th>
                                    <th>Variant</th>
                                    <th>Color</th>
                                    <th class="text-end">Selling Price (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $stockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="items[]" value="<?php echo e($item->id); ?>"
                                                class="form-check-input item-check" onchange="calcSaleTotal()"
                                                <?php echo e(in_array($item->id, old('items', [])) ? 'checked' : ''); ?>>
                                        </td>
                                        <td class="font-monospace small"><?php echo e($item->imei1); ?></td>
                                        <td><?php echo e($item->brand); ?> <?php echo e($item->model); ?></td>
                                        <td><small><?php echo e($item->variant); ?></small></td>
                                        <td><small><?php echo e($item->color); ?></small></td>
                                        <td class="text-end">
                                            <input type="number" name="selling_prices[<?php echo e($item->id); ?>]"
                                                class="form-control form-control-sm text-end price-input"
                                                style="width:110px;display:inline-block" step="0.01" min="0"
                                                value="<?php echo e(old('selling_prices.' . $item->id, $item->selling_price)); ?>"
                                                oninput="calcSaleTotal()">
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">No stock available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($e); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-circle me-1"></i>Complete Sale
            </button>
        </div>
    </form>

    <?php $__env->startPush('scripts'); ?>
        <script>
           /*  $(document).on('change', '#gst', function() {
                if ($(this).is(':checked')) {
                    $('#gst_value').css('display', 'block');

                } else {
                    $('#gst_value').css('display', 'none');
                }
            }); */
            function toggleCustomer() {
                const type = document.querySelector('input[name="customer_type"]:checked').value;
                document.getElementById('existingCustomer').style.display = type === 'existing' ? '' : 'none';
                document.getElementById('walkinCustomer').style.display = type === 'walkin' ? '' : 'none';
            }

            function calcSaleTotal() {
                let total = 0;
                document.querySelectorAll('.item-check:checked').forEach(cb => {
                    const row = cb.closest('tr');
                    const price = parseFloat(row.querySelector('.price-input').value) || 0;
                    total += price;
                });
                const discount = parseFloat(document.getElementById('discountInput').value) || 0;
                const net = Math.max(0, total - discount);
                document.getElementById('itemsTotal').textContent = '₹' + total.toLocaleString('en-IN');
                document.getElementById('netTotal').textContent = '₹' + net.toLocaleString('en-IN');
            }

            toggleCustomer();
            calcSaleTotal();
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\balaguru.m\mobile\resources\views/sales/create.blade.php ENDPATH**/ ?>