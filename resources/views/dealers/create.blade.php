@extends('layouts.app')
@section('title', 'Add Dealer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-building-add me-2"></i>Add Dealer</h4>
    <a href="{{ route('dealers.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>

<div class="card" style="max-width:600px">
    <div class="card-body">
        <form action="{{ route('dealers.store') }}" method="POST">
            @csrf
            @include('dealers._form')
            <button class="btn btn-primary mt-3">Save Dealer</button>
        </form>
    </div>
</div>
@endsection
