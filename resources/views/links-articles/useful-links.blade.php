@extends('layouts.app')
@section('content')
<div ng-cloak ng-controller="UsefulController">
    <div class="row">
        <div class="col-md-12 p-4">
            <h4 class="font-weight-bold text-blue pb-2">Who's Hiring?</h4>
            @if (Auth::user() && Auth::user()->is_active == "YES")
            <div id="accordion-list">
                <ul class="capture-ext-links">
                    @foreach ($links as $link)
                    <li>
                        <a class="expand">
                            <div class="right-arrow">+</div>
                            <h6 class="text-dark mb-0">{{$link->title}}</h6>
                        </a>
                        <div class="detail text-grey">
                            {!! $link->description !!}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @else
            <i><h6 class="text-dark mb-0">This is a premium content page, please <a href="{{ route('register') }}">{{ __('register') }}</a> or <a href="{{ route('login') }}">{{ __('sign in') }}</a> to view</h6></i>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript">

    app.controller('UsefulController', function ($scope, $http, $compile) {

        $scope.hideMessage = function(){
            if($scope.modalErrors){
                delete $scope.modalErrors;
            }
            if($scope.successMessage){
                delete $scope.successMessage;
            }
            if($scope.errors){
                delete $scope.errors;
            }
        }

        $scope.init = function () {
            $scope.form_data = {};
            $scope.isShow = false;
            $scope.errors = $scope.successMessage = $scope.modalErrors = null;
        }

        $scope.init();
    });
</script>
@endsection