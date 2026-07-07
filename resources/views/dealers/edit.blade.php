@extends('layouts.app')
@section('title', 'Edit Dealer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Edit Dealer: {{ $dealer->name }}</h4>
    <a href="{{ route('dealers.show', $dealer) }}" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>

<div class="card" style="max-width:600px">
    <div class="card-body">
        <form action="{{ route('dealers.update', $dealer) }}" method="POST">
            @csrf @method('PUT')
            @include('dealers._form')
            <div class="mb-3">
                <div class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                           {{ old('is_active', $dealer->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>
            <button class="btn btn-primary mt-2">Update Dealer</button>
        </form>
    </div>
</div>
@endsection
