@extends('layouts.app')

@section('title', 'Welcome to CoreUI with Laravel')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <strong>Welcome!</strong>
    </div>
    <div class="card-body">
        <h5 class="card-title">CoreUI is successfully integrated!</h5>
        <p class="card-text">This is a sample page using the CoreUI layout in a Laravel application. You can now start building your UI with CoreUI components.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">Example Card</div>
            <div class="card-body">This is another card.</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">Another Example</div>
            <div class="card-body">This is one more card.</div>
        </div>
    </div>
</div>
@endsection
