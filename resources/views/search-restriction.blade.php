@extends('layouts.signup-app')
@section('content')
<div class="container d-flex align-items-center justify-content-center vh-100">
    <div class="row">
        <div class="col-md-12">
            <h1>Search functionality restricted on page reload</h1>
            <a href="{{ url('/home') }}">
                <i aria-hidden="true" class="fa fa-arrow-left">&nbsp; Back to homepage</i>
            </a>
        </div>
    </div>
</div>
@endsection