@extends('layouts.app')

@section('content')

<div ng-cloak ng-controller="FirmRecruitmentTypeontroller" class="px-2 py-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h4 class="font-weight-bold text-blue">Firm Recruitment Type</h4> 
        </div>
        <div class="col-md-4">
            <button ng-click="addFirmRecruitmentType()" title="Add Firm Recruitment Type" title="Add Firm Recruitment Type" class=" btn btn-circle btn-mn bg-darkblue pull-right rounded-0">
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
            <a href="#"  class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
            <% successMessage %>
        </div>
        <table id="recruitment-type-listing" class="table table-striped table-responsive-sm" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Firm Name</th>
                    <th>Recruitment Type</th>
                    <th>IsActive</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div id="recruitment-type-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <form class="cmxform" ng-submit="firmRecruitmentSubmit(form_data)" ng-model="form_data" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Firm Recruitment Type</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div ng-if="modalErrors" class="alert alert-danger col-md-12">
                                    <a href="#"  class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
                                    <ul class="pl-2 mb-0">
                                        <li ng-repeat="error in modalErrors"><% error %></li>
                                    </ul>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Firm Name</label>
                                    <select class="form-control" ng-model="form_data.firm_id" 
                                            ng-options="firm.id as firm.name for firm in firms" required>
                                            <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Recruitment Type</label>
                                    <select class="form-control" ng-model="form_data.recruitment_id" 
                                            ng-options="type.id as type.name for type in types" required>
                                            <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="form-group form-animate-checkbox col-md-6">
                                    <label class="mb-0">Active</label><br>
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input checkbox"
                                            ng-true-value="'<?php echo \App\FirmRecruitmentType::FLAG_YES; ?>'"
                                            ng-false-value="'<?php echo \App\FirmRecruitmentType::FLAG_NO; ?>'"
                                            ng-model="form_data.is_active" 
                                        />
                                        <span class="switch-label" data-on="Yes" data-off="No"></span>
                                        <span class="switch-handle"></span>
                                    </label>
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
                  <button type="button" ng-if="showDelete" ng-click="deleteConfirmed()" 
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

    app.controller('FirmRecruitmentTypeontroller', function ($scope, $http, $compile) {

        $scope.addFirmRecruitmentType = function(){
            $scope.form_data = $scope.modalErrors  = null;
            $("#recruitment-type-modal").modal('show');
            $scope.getActiveRecruitmentTypes();
            $scope.getActiveFirms();
        }

        $scope.firmRecruitmentSubmit = function(form_data){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'firm-recruitment-type/add-update-type';
            $http.post(url,form_data).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#recruitment-type-modal").modal('hide');
                    $scope.successMessage = response.data.message;
                    $scope.listFirmRecruitmentTypes();
                } else {
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.modalErrors = errors;
                    $("#recruitment-type-modal").animate({ scrollTop: 0 }, "slow");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.editFirmRecrutimentType = function(firm_service_id){
            $(".bg_load").show();
            $scope.modalErrors = null;
            $scope.getActiveRecruitmentTypes();
            $scope.getActiveFirms();
            var url = 'firm-recruitment-type/get-info/' + firm_service_id;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#recruitment-type-modal").modal('show');
                    $scope.form_data  = response.data.firm_recruitment_type;
                } else {
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.modalErrors = errors;
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }
        
        $scope.getActiveRecruitmentTypes = function(){
            $(".bg_load").show();
            var url = 'recruitment-type/get-active-types';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.types = response.data.types;
                } else {
                    alert("Error in fetching active services");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.getActiveFirms = function(){
            $(".bg_load").show();
            var url = 'recruitment-firm/get-active-firms';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.firms = response.data.firms;
                } else {
                    alert("Error in fetching active firms");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.deleteFirmRecrutimentType = function(firm_service_id){
            $scope.reference_to_delete = firm_service_id;
            $scope.showDelete = true;
            $scope.messageToshow = 'You are going to remove this record. Are you sure?';
            $("#delete-confirm").modal('show');
        }

        $scope.deleteConfirmed = function(){
            $(".bg_load").show();
            var url = 'firm-recruitment-type/delete/'+$scope.reference_to_delete;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.successMessage = response.data.message;
                    $scope.listFirmRecruitmentTypes();
                }else{
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.errors = errors;
                    $("html, body").animate({ scrollTop: 0 }, "slow");
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
            $scope.listFirmRecruitmentTypes();
        }

        $scope.listFirmRecruitmentTypes = function(){
            $('#recruitment-type-listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: 'firm-recruitment-type/list-firm-types',
                },
                columns: [
                    {data: 'firm.name', name:'firm.name'},
                    {data: 'recruitment_type.name',name: 'recruitmentType.name'},
                    {data: 'status_text', searchable: false, orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                createdRow: function (row, data, dataIndex) {
                    $compile(angular.element(row).contents())($scope);
                }
            });
        };
        $scope.init();
    });
</script>
@endpush