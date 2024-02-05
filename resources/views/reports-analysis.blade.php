@extends('layouts.app')
@section('content')
<div ng-cloak ng-controller="ReportController">
    <div class="row">
        <div class="col-md-12 pt-4 pb-3 px-4">
            <h4 class="font-weight-bold text-blue pb-2">Reports / Market Updates</h4>
            <p class="text-grey">
            Below is a list of reports and market updates. For some of these reports there is a charge but the cost of the report will be stated in the description. If you would like to receive any of the report/market updates please click on the report and complete the request form. If you have any questions, please contact <a href="mailto:admin@recdirec.com">admin@recdirec.com</a>
        </p>
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
                    <div class="col-lg-4 col-md-6 mb-4 d-flex align-self-stretch" ng-click="confirmEmail('{{$report->description}}','{{$report->id}}')">
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
            <!-- <div class="modal-content rounded-0" style="height:600px;width:1000px;margin-left: -90px;">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
            </div>
            <div style='background-color: white; opacity:0;height: 43px; position: absolute; right: 30px; top:92px; width: 43px;z-index: 2147483647;'> </div>
            <div class="modal-body pt-4" id="modalBody">
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-default br-40 px-4" data-dismiss="modal">Cancel</button>
            </div>
            </div> -->

            <div class="modal-content rounded-0" style="height:600px;width:1000px;margin-left: -90px;">
                <div class="modal-header border-0 rhead" style=" padding: 16px 30px 16px 30px !important;">
                    <h4 class="modal-title text-blue mb-0" id="exampleModalLabel">Request a Report</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-1" id="modalBody">
                    <div class="container-fluid rounded">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="modal-title" id="exampleModalLabel"><% selectedReportDescription %></h6>
                            </div>
                        </div>
                        <hr/ class="mb-0">
                        <div class="row py-3">
                            <!-- <h6 class="modal-title text-center"><b>Partnership Promotions</b></h6> -->                         
                            @foreach ($reports as $report) 
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline" style="align-items: start;">
                                        <input class="form-check-input" type="radio"
                                        ng-model="report_{{$report->id}}.isChecked"
                                        value="{{$report->id}}"  
                                        id="{{$report->id}}_check"
                                        name="report"                       
                                        ng-change="addRemoveSelection({{$report->id}},report_{{$report->id}}, {{$reports}})" 
                                        style="margin-top:3px;"
                                        >  
                                        <label class="form-check-label" for="{{$report->id}}_check">
                                            {{$report->name}}
                                        </label>
                                    </div>  
                                </div>                                              
                            @endforeach
                        </div>
                        <hr/ class="mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div ng-if="modalErrors" class="border-0 mb-3">
                                    <div class="text-danger">
                                        <ul class="mb-0 pl-20">
                                            <li ng-repeat="error in modalErrors" ><% error %></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" ng-submit="reportRequestSubmit(form_data)" ng-model="form_data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Name</label>
                                                <input id="name" type="text" class="form-control mb-1 mtc" ng-model="form_data.name" autocomplete="name" autofocus placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="firm_name" class="col-form-label">Firm Name</label>
                                                <input id="firm_name" type="text" class="form-control mb-1 mtc" ng-model="form_data.firm_name" autocomplete="firm_name" autofocus placeholder="Firm">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="position" class="col-form-label">Position</label>
                                                <input id="position" type="text" class="form-control mb-1 mtc" ng-model="form_data.position" autocomplete="position" autofocus placeholder="Position">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="email" class="col-form-label">Email Address</label>
                                                <input id="email" type="text" class="form-control mb-1 mtc" ng-model="form_data.email" autocomplete="email" autocomplete="email" autofocus placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label for="contact_number" class="col-form-label">Contact Number</label>
                                                <input id="contact_number" type="text" class="form-control mb-1 mtc" ng-model="form_data.year_qualified" autocomplete="year_qualified" autofocus placeholder="Contact Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin:14px auto;">
                                            <div class="form-check form-check-inline" style="align-items: start;padding:0px0px 8px;">
                                                <input class="form-check-input" type="checkbox"
                                                ng-model="form_data.consent"
                                                style="margin-top:4px;"
                                                id="consent">  
                                                <label for="consent" class="form-check-label">
                                                I agree to the <a href="/terms">terms and conditions</a>. If there is a charge for the report, I agree that Recdirec can invoice for the cost of the report. Invoices will be made out to the firm and sent to the individual that requests the report.
                                                </label>
                                            </div>  
                                        </div>
                                        <div class="col-md-4 text-right align-self-center">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-form">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
        $scope.confirmEmail = function(report_description,report_id){
            $scope.form_data = {};
            $('#confirm-mail').modal('show');
            $scope.form_data.consent=null;  
            $scope.modalErrors = $scope.messageToshow = null;

             //Hack to remove and clean selected report
             angular.forEach($scope.selectedReport, function(value, key) {
                document.getElementById(value+'_check').click(); 
            });  

              //Make sure you cleaned it   
              $scope.selectedReport = [];  
              document.getElementById(report_id+'_check').click(); 
              if(report_id) {
                  $scope.selectedReport = [parseInt(report_id)];
              }

            $scope.selectedReportDescription = report_description;
          
        }
        $scope.addRemoveSelection = function (report_id,report, reportsList) {
            if(!report.isChecked){
                $scope.selectedReport = [];
            }else{
                $scope.selectedReport = [];
                $scope.selectedReport.push(report_id);
            }
        }
        $scope.reportRequestSubmit = function(form_data){
            form_data.selectedReport = $scope.selectedReport;
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'reports-analysis/send-selected-report-email';
            $http.post(url,form_data).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $(".bg_load").hide();
                    $('#confirm-mail').modal('hide');  
                    $scope.form_data = {};
                    $scope.selectedReport = [];
                    $('#confirm-done').modal('show');
                    $scope.messageToshow = response.data.message;
                } 
            }).catch(function(response) {               
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value[0]);
                    });
                    
                    $scope.modalErrors = errors;
                    // console.log("error")
            }).finally(function(){
                $(".bg_load").hide();
            });
        }


        // $scope.sendReportEmail = function(report_name){
        //     $(".bg_load").show();
        //     $scope.modalErrors = null;
        //     var url = 'reports-analysis/send-report-email';
        //     $http.post(url,$scope.form_data).then(function (response) {
        //         if (response.data.status == 'SUCCESS') {                    
        //             //$scope.successMessage = response.data.message;
        //             $('#confirm-mail').modal('hide');
        //             $('#confirm-done').modal('show');
        //             $scope.messageToshow = "We have received your request for "+$scope.form_data.report_name+". A copy of this will be sent to you via email.";
        //             $scope.form_data = {};
        //         } else {
        //             var errors = [];
        //             $.each(response.data.errors, function (key, value) {
        //                 errors.push(value);
        //             });
        //             $scope.modalErrors = errors;
        //         }
        //     }).finally(function(){
        //         $(".bg_load").hide();
        //     });
        // }

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
            $scope.selectedReport = [];           
            $scope.selectedReportDescription = '';    
            $scope.form_data = {};
            $scope.errors = $scope.successMessage = $scope.modalErrors = null;
        }

        $scope.init();
    });
    
</script>
@endpush