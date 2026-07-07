<div class="row g-2 align-items-end">
    <div class="col-md-3">
        <label class="form-label form-label-sm">IMEI 1 *</label>
        <input type="text" name="items[{{ $i }}][imei1]" class="form-control form-control-sm @error('items.'.$i.'.imei1') is-invalid @enderror"
               value="{{ old('items.'.$i.'.imei1', $item['imei1'] ?? '') }}" required maxlength="15">
    </div>
    <div class="col-md-3">
        <label class="form-label form-label-sm">IMEI 2</label>
        <input type="text" name="items[{{ $i }}][imei2]" class="form-control form-control-sm"
               value="{{ old('items.'.$i.'.imei2', $item['imei2'] ?? '') }}" maxlength="15">
    </div>
    <div class="col-md-3">
        <label class="form-label form-label-sm">Brand *</label>
        <input type="text" name="items[{{ $i }}][brand]" class="form-control form-control-sm"
               value="{{ old('items.'.$i.'.brand', $item['brand'] ?? '') }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label form-label-sm">Model *</label>
        <input type="text" name="items[{{ $i }}][model]" class="form-control form-control-sm"
               value="{{ old('items.'.$i.'.model', $item['model'] ?? '') }}" required>
    </div>
    <div class="col-md-2">
        <label class="form-label form-label-sm">Variant</label>
        <input type="text" name="items[{{ $i }}][variant]" class="form-control form-control-sm"
               value="{{ old('items.'.$i.'.variant', $item['variant'] ?? '') }}" placeholder="8/128GB">
    </div>
    <div class="col-md-2">
        <label class="form-label form-label-sm">Color</label>
        <input type="text" name="items[{{ $i }}][color]" class="form-control form-control-sm"
               value="{{ old('items.'.$i.'.color', $item['color'] ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label form-label-sm">Price (₹) *</label>
        <input type="number" name="items[{{ $i }}][cost_price]" class="form-control form-control-sm"
               step="0.01" min="0" value="{{ old('items.'.$i.'.cost_price', $item['cost_price'] ?? '') }}" required>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        @if($i > 0)
        <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="removeItem({{ $i }})">
            <i class="bi bi-trash"></i>
        </button>
        @endif
    </div>
</div>
