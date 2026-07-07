<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">IMEI 1 <span class="text-danger">*</span></label>
        <input type="text" name="imei1" class="form-control @error('imei1') is-invalid @enderror"
               value="{{ old('imei1', $stock->imei1 ?? '') }}" required maxlength="20">
        @error('imei1')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">IMEI 2 (Dual SIM)</label>
        <input type="text" name="imei2" class="form-control" value="{{ old('imei2', $stock->imei2 ?? '') }}" maxlength="20">
    </div>
    <div class="col-md-4">
        <label class="form-label">Brand <span class="text-danger">*</span></label>
        <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror"
               value="{{ old('brand', $stock->brand ?? '') }}" required>
        @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Model <span class="text-danger">*</span></label>
        <input type="text" name="model" class="form-control @error('model') is-invalid @enderror"
               value="{{ old('model', $stock->model ?? '') }}" required>
        @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Variant (RAM/Storage)</label>
        <input type="text" name="variant" class="form-control" placeholder="e.g. 8GB/128GB"
               value="{{ old('variant', $stock->variant ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Color</label>
        <input type="text" name="color" class="form-control" value="{{ old('color', $stock->color ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Dealer</label>
        <select name="dealer_id" class="form-select">
            <option value="">— Select Dealer —</option>
            @foreach($dealers as $d)
            <option value="{{ $d->id }}" {{ old('dealer_id', $stock->dealer_id ?? '') == $d->id ? 'selected' : '' }}>
                {{ $d->name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Date Added <span class="text-danger">*</span></label>
        <input type="date" name="date_added" class="form-control"
               value="{{ old('date_added', isset($stock) ? $stock->date_added->format('Y-m-d') : date('Y-m-d')) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Cost Price (₹) <span class="text-danger">*</span></label>
        <input type="number" name="cost_price" class="form-control @error('cost_price') is-invalid @enderror"
               step="0.01" min="0" value="{{ old('cost_price', $stock->cost_price ?? '') }}" required>
        @error('cost_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Selling Price (₹) <span class="text-danger">*</span></label>
        <input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror"
               step="0.01" min="0" value="{{ old('selling_price', $stock->selling_price ?? '') }}" required>
        @error('selling_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Warranty Period</label>
        <input type="text" name="warranty_period" class="form-control" placeholder="e.g. 1 year"
               value="{{ old('warranty_period', $stock->warranty_period ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Box Contents</label>
        <input type="text" name="box_contents" class="form-control" placeholder="Charger, Cable, Earphones..."
               value="{{ old('box_contents', $stock->box_contents ?? '') }}">
    </div>
</div>
