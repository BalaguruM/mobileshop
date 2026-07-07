@extends('layouts.app')
@section('title', 'New Purchase from Dealer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-cart-plus me-2"></i>New Purchase from Dealer</h4>
    <a href="{{ route('dealer-transactions.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>

<form action="{{ route('dealer-transactions.store') }}" method="POST" id="purchaseForm">
    @csrf
    <div class="row g-3">
        <!-- Left: Transaction Details -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Transaction Details</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Dealer <span class="text-danger">*</span></label>
                        <select name="dealer_id" class="form-select @error('dealer_id') is-invalid @enderror" required>
                            <option value="">— Select Dealer —</option>
                            @foreach($dealers as $d)
                            <option value="{{ $d->id }}" {{ (request('dealer_id') == $d->id || old('dealer_id') == $d->id) ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('dealer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="purchase" {{ old('type')=='purchase'?'selected':'' }}>Outright Purchase</option>
                            <option value="borrow" {{ old('type')=='borrow'?'selected':'' }}>Borrowed / Credit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Due Date (for credit)</label>
                        <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount Paid Now (₹)</label>
                        <input type="number" name="paid_amount" class="form-control" step="0.01" min="0" value="{{ old('paid_amount', 0) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Mode</label>
                        <select name="payment_mode" class="form-select">
                            <option value="cash">Cash</option>
                            <option value="upi">UPI</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Card</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Items -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Items Received</span>
                    <button type="button" class="btn btn-sm btn-success" onclick="addItem()">
                        <i class="bi bi-plus"></i> Add Item
                    </button>
                </div>
                <div class="card-body p-2" id="itemsContainer">
                    @if($errors->any())
                        @foreach(old('items', []) as $i => $item)
                        <div class="item-row border border-primary rounded p-2 mb-2" id="row_{{ $i }}">
                            @include('dealer-transactions._item_row', ['i' => $i, 'item' => $item])
                        </div>
                        @endforeach
                    @else
                    <div class="item-row border border-primary rounded p-2 mb-2" id="row_0">
                        @include('dealer-transactions._item_row', ['i' => 0, 'item' => []])
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <strong>Total Cost: <span id="totalCost">₹0</span></strong>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="mt-3">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-circle me-1"></i>Save Purchase
        </button>
    </div>
</form>

@push('scripts')
<script>
let rowCount = {{ $errors->any() ? count(old('items', [[]])) : 1 }};
// Listen for keypress on a number input
document.getElementById('repeatInput').addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        const times = parseInt(this.value);
        if (!isNaN(times) && times > 0) {
            for (let i = 0; i < times; i++) {
                addItem();
            }
            this.value = ''; // clear after adding
        }
    }
});
function addItem() {
    const i = rowCount++;
    const container = document.getElementById('itemsContainer');
    const div = document.createElement('div');
    div.className = 'item-row border border-primary rounded p-2 mb-2';
    div.id = 'row_' + i;
    div.innerHTML = itemRowHtml(i);
    container.appendChild(div);
    calcTotal();
}

function removeItem(i) {
    const el = document.getElementById('row_' + i);
    if (el) el.remove();
    calcTotal();
}

function calcTotal() {
    let total = 0;
    document.querySelectorAll('input[name^="items"][name$="[cost_price]"]').forEach(el => {
        total += parseFloat(el.value) || 0;
    });
    document.getElementById('totalCost').textContent = '₹' + total.toLocaleString('en-IN');
}

document.addEventListener('input', function(e) {
    if (e.target.matches('input[name*="cost_price"]')) calcTotal();
});

function itemRowHtml(i) {
    return `
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label form-label-sm">IMEI 1*</label>
            <input type="text" name="items[${i}][imei1]" class="form-control form-control-sm" required maxlength="15">
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-sm">IMEI 2</label>
            <input type="text" name="items[${i}][imei2]" class="form-control form-control-sm" maxlength="15">
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-sm">Brand*</label>
            <input type="text" name="items[${i}][brand]" class="form-control form-control-sm" required>
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-sm">Model*</label>
            <input type="text" name="items[${i}][model]" class="form-control form-control-sm" required>
        </div>
        <div class="col-md-2">
            <label class="form-label form-label-sm">Variant</label>
            <input type="text" name="items[${i}][variant]" class="form-control form-control-sm" placeholder="8/128GB">
        </div>
        <div class="col-md-2">
            <label class="form-label form-label-sm">Color</label>
            <input type="text" name="items[${i}][color]" class="form-control form-control-sm">
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-sm">Price (₹)*</label>
            <input type="number" name="items[${i}][cost_price]" class="form-control form-control-sm" step="0.01" min="0" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="removeItem(${i})">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>`;
}
calcTotal();
</script>
@endpush
@endsection
