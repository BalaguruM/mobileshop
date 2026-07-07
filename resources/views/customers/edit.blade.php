@extends('layouts.app')
@section('title', 'Edit Customer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Edit Customer: {{ $customer->name }}</h4>
    <a href="{{ route('customers.show', $customer) }}" class="btn btn-outline-secondary btn-sm">← Back</a>
</div>
<div class="card" style="max-width:600px">
    <div class="card-body">
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf @method('PUT')
            @include('customers._form')
            <button class="btn btn-primary mt-3">Update Customer</button>
        </form>
    </div>
</div>
@endsection
