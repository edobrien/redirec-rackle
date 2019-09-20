@extends('layouts.app')
@section('content')
<div ng-cloak ng-controller="HelpfulController">
    <div class="row">
        <div class="col-md-12 p-4">
            <h4 class="font-weight-bold text-blue pb-2">Helpful Articles</h4>
            <div id="accordion-list">
                <ul>
                    @foreach ($articles as $article)
                    <li>
                        <a class="expand">
                            <div class="right-arrow">+</div>
                            <h6 class="text-dark mb-0">{{$article->title}}</h6>
                        </a>
                        <div class="detail text-grey">
                            {!! $article->description !!}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    app.controller('HelpfulController', function ($scope, $http, $compile) {

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