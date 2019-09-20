@extends('layouts.app')

@section('content')

<div ng-cloak ng-controller="FirmAreaController" class="px-2 py-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h4 class="font-weight-bold text-blue">Firm Practice Area</h4> 
        </div>
        <div class="col-md-4">
            <button ng-click="addFirmArea()" title="Add Firm Area" title="Add Firm Area" class=" btn btn-circle btn-mn bg-darkblue pull-right rounded-0">
                <span class="fa fa-plus text-white"></span>
            </button>
        </div>
    </div>
    <div class="responsive-table">
        <div ng-hide="!errors" class="alert alert-danger">
            <a href="#" class="close" ng-click="hideMessage()" aria-label="close">&times;</a>
            <ul>
                <li ng-repeat="error in errors"><% error %></li>
            </ul>
        </div>
        <div ng-hide="!successMessage"  class="alert alert-success">
            <a href="#"  class="close" ng-click="hideMessage()" aria-label="close">&times;</a>
            <% successMessage %>
        </div>
        <table id="firm-area-listing" class="table table-striped table-responsive-sm" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Firm Name</th>
                    <th>Practice Area</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div id="firm-area-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <form class="cmxform" ng-submit="firmAreaSubmit(form_data)" ng-model="form_data" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Firm Practice Area</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div ng-if="modalErrors" class="alert alert-danger col-md-12">
                                    <ul>
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
                                    <label class="mb-0">Practice Area</label>
                                    <select class="form-control" ng-model="form_data.practice_area_id" 
                                            ng-options="area.id as area.name group by area.type for area in areas" required>
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
    
    app.controller('FirmAreaController', function ($scope, $http, $compile) {

        $scope.addFirmArea = function(){
            $scope.form_data = $scope.modalErrors  = null;
            $("#firm-area-modal").modal('show');
            $scope.getActivePracticeAreas();
            $scope.getActiveFirms();
        }

        $scope.firmAreaSubmit = function(form_data){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'firm-practice-area/add-update-area';
            $http.post(url,form_data).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#firm-area-modal").modal('hide');
                    $scope.successMessage = response.data.message;
                    $scope.listFirmAreas();
                } else {
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.modalErrors = errors;
                    $("#firm-area-modal").animate({ scrollTop: 0 }, "slow");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.editFirmArea = function(firm_area_id){
            $(".bg_load").show();
            $scope.modalErrors = null;
            $scope.getActivePracticeAreas();
            $scope.getActiveFirms();
            var url = 'firm-practice-area/get-info/' + firm_area_id;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#firm-area-modal").modal('show');
                    $scope.form_data  = response.data.firm_area;
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
        
        $scope.getActivePracticeAreas = function(){
            $(".bg_load").show();
            var url = 'practice-area/get-active-areas';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.areas = response.data.areas;
                } else {
                    alert("Error in fetching active practice areas");
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

        $scope.deleteFirmArea = function(firm_area_id){
            $scope.reference_to_delete = firm_area_id;
            $scope.showDelete = true;
            $scope.messageToshow = 'You are going to remove this record. Are you sure?';
            $("#delete-confirm").modal('show');
        }

        $scope.deleteConfirmed = function(){
            $(".bg_load").show();
            var url = 'firm-practice-area/delete/'+$scope.reference_to_delete;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.successMessage = response.data.message;
                    $scope.listFirmAreas();
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
            $scope.listFirmAreas();
        }

        $scope.listFirmAreas = function(){
            $('#firm-area-listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: 'firm-practice-area/list-firm-areas',
                },
                columns: [
                    {data: 'firm.name', name:'firm.name'},
                    {data: 'practice_area.name',name: 'practiceArea.name'},
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