@extends('layouts.app')
@section('content')
<div ng-cloak ng-controller="FeedbackController">
    <div class="row">
        <div class="col-md-12 pt-4 pb-4 px-4">
            <h4 class="font-weight-bold text-blue pb-2">Surveys</h4>
            <p class="text-grey">Please see below links to some surveys that we have created.  Please do take part in these surveys, they have been designed that they only take 2mins to complete and all information is treated with the strictest confidence.   Once we have sufficient responses, we will anonymise and aggregate the survey data to produce a report that we will provide for free to all those that have taken part.</p>
            <a href="<% link.url %>" target="_blank" class="btn btn-outline-secondary btn-sm br-40 mr-2 mb-2 px-3 fs-12" ng-repeat="link in survey_links"><% link.title %></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 px-4 pb-3">
            <h4 class="font-weight-bold text-blue pb-2">Feedback</h4>
            <p class="text-grey">We welcome any feedback in respect of the site on things that you think could be improved or additional functionality that you would like to see.</p>
            <div ng-hide="!errors" class="alert alert-danger">
                <a href="#" class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
                <ul class="pl-2 mb-0">
                    <li ng-repeat="error in errors"><% error %></li>
                </ul>
            </div>
            <div ng-hide="!successMessage"  class="alert alert-success">
                <a href="#" class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
                <% successMessage %>
            </div>
            <form method="post" ng-submit="feedbackSubmit(form_data)" ng-model="form_data">
                <textarea class="form-control" ng-model="form_data.description" id="feedback" rows="5" required></textarea>
                <button type="submit" class="btn btn-form br-40 mt-3 px-4">Submit</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    app.controller('FeedbackController', function ($scope, $http, $compile) {

        $scope.feedbackSubmit = function(form_data){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'feedback/save-form';
            $http.post(url,form_data).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $(".bg_load").hide();
                    $scope.form_data = {};
                    $scope.successMessage = response.data.message;
                } else {
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.modalErrors = errors;
                    $(".bg_load").hide();
                }
            });
        }
    
        $scope.getSurvetLinks = function(){
            $(".bg_load").show();
            var url = 'survey/get-active-surveys';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $(".bg_load").hide();
                    $scope.survey_links = response.data.surveys;
                } else {
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.modalErrors = errors;
                    alert("Error in getting survey links");
                    $(".bg_load").hide();
                }
            });
        }

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
            $scope.errors = $scope.successMessage = $scope.modalErrors = null;
            $scope.getSurvetLinks();
        }

        $scope.init();
    });
</script>
@endsection