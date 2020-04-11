@extends('layouts.app')

@section('content')

<div ng-cloak ng-controller="FirmLocationController" class="px-2 py-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h4 class="font-weight-bold text-blue">Firm Hire Locations</h4> 
        </div>
        <div class="col-md-4">
            <button ng-click="addFirmLocation()" title="Add Firm Location" title="Add Firm Location" class=" btn btn-circle btn-mn bg-darkblue pull-right rounded-0">
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
        <table id="firm-location-listing" class="table table-striped table-responsive-sm" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Firm Name</th>
                    <th>Hire Location Name</th>                   
                    <th>IsActive</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div id="firm-location-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <form class="cmxform" ng-submit="firmLocationSubmit(form_data)" ng-model="form_data" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Firm Hire Location</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div ng-if="modalErrors" class="alert alert-danger  col-md-12">
                                    <a href="#"  class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
                                    <ul class="pl-2 mb-0">
                                        <li ng-repeat="error in modalErrors"><% error %></li>
                                    </ul>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Firm Name</label>
                                    <select class="form-control" ng-model="form_data.firm_id" 
                                            ng-options="firm.id as firm.name for firm in firms" required></select>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Hire Location Name</label>
                                    
                                    <select class="form-control" ng-model="form_data.hire_location_id" 
                                            ng-options="hire_location.id as hire_location.name for hire_location in hire_locations" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>                                
                                <div class="form-group form-animate-checkbox col-md-6">
                                    <label class="mb-0">Active</label><br>
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input checkbox"
                                            ng-true-value="'<?php echo \App\FirmLocation::FLAG_YES; ?>'"
                                            ng-false-value="'<?php echo \App\FirmLocation::FLAG_NO; ?>'"
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
                  <button type="button" ng-if="showDelete" ng-click="deleteFirmLocationConfirmed()" 
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

    app.controller('FirmLocationController', function ($scope, $http, $compile) {

        $scope.addFirmLocation = function(){
            $scope.form_data = $scope.modalErrors  = null;
            $("#firm-location-modal").modal('show');
            $scope.getActiveLocations();
            $scope.getActiveFirms();
        }

        $scope.firmLocationSubmit = function(form_data){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = '/firm-hire-location/add-update-firm-location';
            $http.post(url,form_data).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#firm-location-modal").modal('hide');
                    $scope.successMessage = response.data.message;
                    $scope.listFirmLocations();
                } else {
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.modalErrors = errors;
                    $("#firm-location-modal").animate({ scrollTop: 0 }, "slow");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.editFirmLocation = function(firm_location_id){
            $(".bg_load").show();
            $scope.modalErrors = null;
            $scope.getActiveLocations();
            $scope.getActiveFirms();
            var url = '/firm-hire-location/get-info/' + firm_location_id;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#firm-location-modal").modal('show');
                    $scope.form_data  = response.data.firm_location;
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
        
        $scope.getActiveLocations = function(){
            $(".bg_load").show();
            var url = '/hire-location/get-active-hire-locations';
            console.log(url);
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.hire_locations = response.data.hire_locations;
                } else {
                    alert("Error in fetching active locations");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.getActiveFirms = function(){
            $(".bg_load").show();
            var url = '/recruitment-firm/get-active-firms';
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

        $scope.deleteFirmLocation = function(firm_location_id){
            $scope.reference_to_delete = firm_location_id;
            $scope.showDelete = true;
            $scope.messageToshow = 'You are going to remove this record. Are you sure?';
            $("#delete-confirm").modal('show');
        }

        $scope.deleteFirmLocationConfirmed = function(){
            $(".bg_load").show();
            var url = '/firm-hire-locations/delete/'+$scope.reference_to_delete;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.successMessage = response.data.message;
                    $scope.listFirmLocations();
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
            $scope.listFirmLocations();
        }

        $scope.listFirmLocations = function(){
            $('#firm-location-listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '/firm-hire-location/list-firm-locations',
                },
                columns: [
                    {data: 'firm.name', name:'firm.name'},
                    {data: 'hire_location.name',name: 'hireLocation.name'},
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