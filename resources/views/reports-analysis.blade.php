@extends('layouts.app')
@section('content')
<div ng-cloak ng-controller="ReportController">
    <div class="row">
        <div class="col-md-12 pt-4 pb-3 px-4">
            <h4 class="font-weight-bold text-blue pb-2">Reports / Analysis</h4>
            <p class="text-grey">Below a list of reports that we have compiled. Please click on the relevant card to see the report. If you would like a copy emailed to you, please email <a href="mailto:edobrien@recdirec.com">edobrien@recdirec.com</a> naming the report that you would like to be sent. If you have any thoughts / requests for us to compile any other reports /analysis that would be helpful, please do let us know through our feeback page.</p>
        </div>
    </div>
    @if(count($reports))
    <div class="row">
        <div class="col-md-12 px-4 pb-3">
            <h4 class="font-weight-bold text-blue pb-2">Request a Report</h4>
            <div class="practice-area">
            <div ng-hide="!errors" class="alert alert-danger">
                <a href="#" class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
                <ul class="pl-2 mb-0">
                    <li ng-repeat="error in errors"><% error %></li>
                </ul>
            </div>
            <div ng-hide="!successMessage"  class="alert alert-success">
                <a href="#"  class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
                <% successMessage %>
            </div>
                <div class="row bg-dynamic">
                    @foreach ($reports as $report)
                    <div class="col-lg-4 col-md-6 mb-4 d-flex align-self-stretch" ng-click="confirmEmail('{{$report->report_doc}}')">
                        <div class="card rounded-0 border-0 w-100 cursor-pointer">
                            <div class="card-body pb-0">
                                <h6 class="card-title text-white">{{$report->name}}</h6>
                                <p class="text-white">{{$report->description}}</>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- confirm modal begins -->
    <div id="confirm-mail" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-0" style="height:600px;width:1000px;margin-left: -90px;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
            </div>
            <div style='background-color: white; opacity:0;height: 43px; position: absolute; right: 30px; top:92px; width: 43px;z-index: 2147483647;'> </div>
            <div class="modal-body pt-4" id="modalBody">
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-default br-40 px-4" data-dismiss="modal">Cancel</button>
            </div>
            </div>
        </div>
    </div>
    <div id="confirm-done" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
            <div class="modal-header">
                <h4 class="modal-title font-weight-bold">Request Received</h4>
            </div>
            <div class="modal-body pt-4">
                <p><% messageToshow %></p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-default btn-success br-40 px-4" data-dismiss="modal">Ok</button>
            </div>
            </div>
        </div>
    </div>
</div>
<!--  confirm modal ends -->
@endsection
@push('scripts')
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script type="text/javascript">
    app.controller('ReportController', function ($scope, $http, $compile) {
        $scope.confirmEmail = function(report_url){
            $scope.modalErrors = $scope.messageToshow = null;
            $('#confirm-mail').modal('show');
            $('#modalBody').empty();
            $('#modalBody').html(report_url);
            $('iframe').css('height', '100%');
            $('iframe').css('width', '100%');
        }

        $scope.sendReportEmail = function(report_name){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'reports-analysis/send-report-email';
            $http.post(url,$scope.form_data).then(function (response) {
                if (response.data.status == 'SUCCESS') {                    
                    //$scope.successMessage = response.data.message;
                    $('#confirm-mail').modal('hide');
                    $('#confirm-done').modal('show');
                    $scope.messageToshow = "We have received your request for "+$scope.form_data.report_name+". A copy of this will be sent to you via email.";
                    $scope.form_data = {};
                } else {
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.modalErrors = errors;
                }
            }).finally(function(){
                $(".bg_load").hide();
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
        }

        $scope.init();
    });
    
</script>
@endpush