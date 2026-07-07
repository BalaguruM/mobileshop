@extends('layouts.app')
@section('title', 'New Sale')

@section('content')
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
        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
    </div>

    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
        @csrf
        <div class="row g-3">
            <!-- Left: Customer & Payment -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Customer</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" id="ct_existing"
                                    value="existing" {{ old('customer_type', 'existing') == 'existing' ? 'checked' : '' }}
                                    onchange="toggleCustomer()">
                                <label class="form-check-label" for="ct_existing">Existing</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" id="ct_walkin"
                                    value="walkin" {{ old('customer_type') == 'walkin' ? 'checked' : '' }}
                                    onchange="toggleCustomer()">
                                <label class="form-check-label" for="ct_walkin">Walk-in</label>
                            </div>
                        </div>
                        <div id="existingCustomer">
                            <select name="customer_id" class="form-select form-select-sm">
                                <option value="">— Select Customer —</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}"
                                        {{ request('customer_id') == $c->id || old('customer_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }} {{ $c->phone ? '(' . $c->phone . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="walkinCustomer" style="display:none">
                            <input type="text" name="customer_name_override" class="form-control form-control-sm"
                                placeholder="Customer name (optional)" value="{{ old('customer_name_override') }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Payment</div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label form-label-sm">Mode <span class="text-danger">*</span></label>
                            <select name="payment_mode" class="form-select form-select-sm" required>
                                <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="upi" {{ old('payment_mode') == 'upi' ? 'selected' : '' }}>UPI</option>
                                <option value="card" {{ old('payment_mode') == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="credit" {{ old('payment_mode') == 'credit' ? 'selected' : '' }}>Credit / Due
                                </option>
                                <option value="emi" {{ old('payment_mode') == 'emi' ? 'selected' : '' }}>EMI</option>
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
                                <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="18" {{ old('gst_value') == 18 ? 'selected' : '' }}>18%(mobiles)</option>
                                <option value="28" {{ old('gst_value') == 28 ? 'selected' : '' }}>28%</option>
                                <option value="12" {{ old('gst_value') == 12 ? 'selected' : '' }}>12%
                                </option>
                                <option value="0" {{ old('gst_value') == 0 ? 'selected' : '' }}>0%</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label form-label-sm">Discount (₹)</label>
                            <input type="number" name="discount" id="discountInput" class="form-control form-control-sm"
                                step="0.01" min="0" value="{{ old('discount', 0) }}" oninput="calcSaleTotal()">
                        </div>
                        <div class="mb-2">
                            <label class="form-label form-label-sm">Amount Paid (₹)</label>
                            <input type="number" name="paid_amount" class="form-control form-control-sm" step="0.01"
                                min="0" value="{{ old('paid_amount', 0) }}" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label form-label-sm">Due Date</label>
                            <input type="date" name="due_date" class="form-control form-control-sm"
                                value="{{ old('due_date') }}">
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
                                @forelse($stockItems as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="items[]" value="{{ $item->id }}"
                                                class="form-check-input item-check" onchange="calcSaleTotal()"
                                                {{ in_array($item->id, old('items', [])) ? 'checked' : '' }}>
                                        </td>
                                        <td class="font-monospace small">{{ $item->imei1 }}</td>
                                        <td>{{ $item->brand }} {{ $item->model }}</td>
                                        <td><small>{{ $item->variant }}</small></td>
                                        <td><small>{{ $item->color }}</small></td>
                                        <td class="text-end">
                                            <input type="number" name="selling_prices[{{ $item->id }}]"
                                                class="form-control form-control-sm text-end price-input"
                                                style="width:110px;display:inline-block" step="0.01" min="0"
                                                value="{{ old('selling_prices.' . $item->id, $item->selling_price) }}"
                                                oninput="calcSaleTotal()">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">No stock available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-circle me-1"></i>Complete Sale
            </button>
        </div>
    </form>

    @push('scripts')
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
    @endpush
@endsection
