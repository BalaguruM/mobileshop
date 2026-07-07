@extends('layouts.app')
@section('title', 'Add Customer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-person-plus me-2"></i>Add Customer</h4>
    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>
<div class="card" style="max-width:600px">
    <div class="card-body">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            @include('customers._form')
            <button class="btn btn-primary mt-3">Save Customer</button>
        </form>
    </div>
</div>
@endsection
