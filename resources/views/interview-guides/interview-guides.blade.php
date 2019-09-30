@extends('layouts.app')
@section('content')
<div ng-cloak ng-controller="InterviewDetailController">
    <div class="row">
        <div class="col-md-12 p-4">
            <h4 class="font-weight-bold text-blue pb-2">Interview/Resourcing Advice</h4>
            <div class="practice-area">
                <div class="row bg-dynamic">
                    @foreach ($guides as $guide)
                    <div class="col-lg-4 col-md-6 mb-4 d-flex align-self-stretch">
                        <div class="card rounded-0 border-0 w-100 cursor-pointer" 
                            ng-click="getDetailPage({{$guide->id}})">
                            <div class="card-body pb-0">
                                <h6 class="card-title lh5 text-white">
                                    {{$guide->title}}
                                </h6>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                @if(Auth::user()->is_admin == "YES")
                                <small class="text-white"><strong>{{$guide->view_count}}</strong></small>
                                @endif
                                <ion-icon name="arrow-round-forward" class="float-right mt-1 text-white"></ion-icon>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    app.controller('InterviewDetailController', function ($scope, $http, $compile) {

        $scope.getDetailPage = function(detail_id){
            $(".bg_load").show();
            var url = '/interview-guide-detail';
            $scope.form_data = {};
            $scope.form_data.detail_id = detail_id;
            $http.post(url,$scope.form_data).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $(".bg_load").hide();
                    $scope.form_data = {};
                    window.location.href = "/interview-guide-detail/"+detail_id;
                } else {
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.modalErrors = errors;
                    $(".bg_load").hide();
                    alert("Page not found");
                }
            });
        }

        $scope.init = function () {
            $scope.form_data = {};
        }

        $scope.init();
    });
</script>
@endsection