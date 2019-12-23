@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 p-4 bg-details">
        <h4 class="font-weight-bold text-blue pb-2">{{$guide->title}}</h4>
        <div class="guide-details capture-ext-links">
            <div class="row pb-4">
                <div class="col-lg-12">
                    {!! $guide->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection