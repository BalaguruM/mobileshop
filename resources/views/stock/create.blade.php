@extends('layouts.app')
@section('title', 'Add Stock Item')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Add Stock Item</h4>
    <a href="{{ route('stock.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>
<div class="card" style="max-width:700px">
    <div class="card-body">
        <form action="{{ route('stock.store') }}" method="POST">
            @csrf
            @include('stock._form')
            <button class="btn btn-primary mt-3">Save Item</button>
        </form>
    </div>
</div>
@endsection
