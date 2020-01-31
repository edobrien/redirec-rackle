@extends('layouts.app')

@section('content')

<div ng-cloak ng-controller="ReportController" class="px-2 py-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h4 class="font-weight-bold text-blue">Reports</h4> 
        </div>
        <div class="col-md-4">
            <button ng-click="addReport()" title="Add Report" title="Add Report" class=" btn btn-circle btn-mn bg-darkblue pull-right rounded-0">
                <span class="fa fa-plus text-white"></span>
            </button>
        </div>
    </div>
    <div class="responsive-table">
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
        <table id="report-listing" class="table table-striped table-responsive-sm table-responsive-md  table-responsive-lg" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Report Name</th>
                    <th>Description</th>
                    <th>Ordering</th>
                    <th>IsActive</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div id="report-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <form class="cmxform" ng-submit="reportSubmit(form_data)" ng-model="form_data" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Report</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div ng-if="modalErrors" class="alert alert-danger col-md-12">
                                    <a href="#" class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
                                    <ul class="pl-2 mb-0">
                                        <li ng-repeat="error in modalErrors"><% error %></li>
                                    </ul>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Report Name</label>
                                    <input type="text" class="form-text" ng-model="form_data.name" required>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Ordering</label>
                                    <input type="number" class="form-text" ng-model="form_data.ordering" required>
                                </div>
                                <div class="form-group form-animate-text col-md-12">
                                    <label class="mb-0">Description</label><br>
                                    <textarea rows="4" ng-model="form_data.description" required style="width: 100%" class="form-text"></textarea>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Report Document</label>
                                    <input type="file" accept="application/pdf"  ng-model="form_data.report_doc" id="report_doc" file-model="report_doc"><br>
                                </div>
                                <div class="form-group form-animate-checkbox col-md-6">
                                    <label class="mb-0">Active</label><br>
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input checkbox"
                                            ng-true-value="'<?php echo \App\Report::FLAG_YES; ?>'"
                                            ng-false-value="'<?php echo \App\Report::FLAG_NO; ?>'"
                                            ng-model="form_data.is_active" 
                                        />
                                        <span class="switch-label" data-on="Yes" data-off="No"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </div>
                                <div class="form-group form-animate-text col-md-2" ng-if="form_data.report_doc">
                                    <input class="btn btn-sm bg-blue br-40 w-100" ng-click="getReport(form_data.report_doc)" 
                                        type="button" value="Download">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default br-40 px-4" data-dismiss="modal">Close</button>
                            <input class="submit btn btn-form br-40 px-4" type="submit" value="Submit">
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- delete modal begins -->
        <div id="delete-confirm" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content rounded-0">
                <div class="modal-header">
                  <h4 class="modal-title font-weight-bold">Alert</h4>
                </div>
                <div class="modal-body pt-4">
                    <p><% messageToshow %></p>
                </div>
                <div class="modal-footer border-0">
                  <button type="button" class="btn btn-default br-40 px-4" data-dismiss="modal">No</button>
                  <button type="button" ng-if="showDelete" ng-click="deleteReportConfirmed()" 
                          class="btn btn-danger br-40 px-4" data-dismiss="modal">Yes</button>
                </div>
              </div>
            </div>
        </div>
        <!--  delete modal ends -->
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">

    app.controller('ReportController', function ($scope, $http, $compile, fileUpload) {

        $scope.addReport = function(){
            $scope.form_data = {};
            $('#report_doc').val('');
            $scope.modalErrors  = null;
            $("#report-modal").modal('show');
        }

        $scope.getReport = function(report_doc){
            if(report_doc){
                window.open(window.location.origin+'<?php echo \App\SiteConstants::APP_ASSET_REPORT; ?>'+report_doc, '_blank');
            } else {
                alert("File not found");
            }
        }

        $scope.reportSubmit = function(form_data){
            var errors = [];
            $scope.modalErrors = null;
            form_data.report_doc = $scope.report_doc;
            if(form_data.report_doc == null || form_data.report_doc == undefined){
                errors.push('Please select report document');
            }
            if(errors != ''){
                $scope.modalErrors = errors;
                $('html, body').animate({scrollTop : 0},400);
            }else{
                $(".bg_load").show();
                fileUpload.uploadFileToUrl(form_data, 'reports/add-update-report').then(function(response) {
                    if (response.data.status == 'SUCCESS') {
                        $scope.form_data = {};
                        $('#report_doc').val('');
                        $scope.successMessage = response.data.message;
                        $scope.listReports();
                    } else {
                        var errors = [];
                        $.each(response.data.errors, function (key, value) {
                            errors.push(value);
                        });
                        $scope.modalErrors = errors;
                        $('html, body').animate({scrollTop : 0},400);
                    }
                }).finally(function() {
                    $("#report-modal").modal('hide');
                    $(".bg_load").hide();
                });
            }
        }

        $scope.editReport = function(report_id){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'reports/get-info/' + report_id;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#report-modal").modal('show');
                    $scope.form_data  = response.data.report;
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
        
        $scope.deleteReport = function(report_id){
            $scope.reference_to_delete = report_id;
            $scope.messageToshow = 'You are going to remove this record. Are you sure?';
            $scope.showDelete = true;
            $("#delete-confirm").modal('show');
        }

        $scope.deleteReportConfirmed = function(){
            $(".bg_load").show();
            var url = 'reports/delete/'+$scope.reference_to_delete;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.showDelete = false;
                    $scope.listReports();
                }else{
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.errors = errors;
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
            $scope.form_data.report_doc = {};
            $scope.errors = $scope.successMessage = $scope.modalErrors = null;
            $scope.listReports();
        }

        $scope.listReports = function(){
            $('#report-listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: 'reports/list-report',
                },
                columns: [
                    {data: 'name'},
                    {data: 'description',width:'63%'},
                    {data: 'ordering'},
                    {data: 'status_text', searchable: false, orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                createdRow: function (row, data, dataIndex) {
                    $compile(angular.element(row).contents())($scope);
                },"fnDrawCallback":function(){
                    if($(this).DataTable().row().data()===undefined 
                        && $(this).DataTable().page.info().page !=0){
                        $(this).DataTable().state.clear();
                        $scope.listUsers();
                    }
                }
            });
        };
        $scope.init();
    });

    app.service('fileUpload', ['$http', function ($http) {
        this.uploadFileToUrl = function(form_data, url){
            var fd = new FormData();
            for (var key in form_data) {
                fd.append(key, form_data[key]);
            }
            return $http.post(url,fd ,{
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            });
        }
    }]);

    app.directive('fileModel', ['$parse', function ($parse) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                var model = $parse(attrs.fileModel);
                var modelSetter = model.assign;
                element.bind('change', function(){
                    scope.$apply(function(){
                        // file size kb to mb convert 
                        var fileSize=((element[0].files[0].size)/1048576);
                        if(parseInt(fileSize)>4){
                            alert("File size too large"); 
                            $('#report_doc').val('');
                        }else{
                            modelSetter(scope, element[0].files[0]);    
                        }
                    });
                });
            }
        };
    }]);
</script>
@endpush