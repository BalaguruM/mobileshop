@extends('layouts.app')
@section('title', 'Edit Stock Item')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Edit: {{ $stock->brand }} {{ $stock->model }}</h4>
    <a href="{{ route('stock.show', $stock) }}" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px">
    <div class="card-body">
        <form action="{{ route('stock.update', $stock) }}" method="POST">
            @csrf @method('PUT')
            @include('stock._form')
            <div class="row g-3 mt-1">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach(['in_stock','sold','returned','damaged'] as $s)
                        <option value="{{ $s }}" {{ $stock->status === $s ? 'selected' : '' }}>
                            {{ str_replace('_',' ',ucfirst($s)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button class="btn btn-primary mt-3">Update Item</button>
        </form>
    </div>
</div>
@endsection
