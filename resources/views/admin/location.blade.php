@extends('layouts.app')

@section('content')

<div ng-cloak ng-controller="LocationController" class="px-2 py-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h4 class="font-weight-bold text-blue">Locations</h4> 
        </div>
        <div class="col-md-4">
            <button ng-click="addLocation()" title="Add Location" title="Add Location" class=" btn btn-circle btn-mn bg-darkblue pull-right rounded-0">
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
        <table id="location-listing" class="table table-striped table-responsive-sm" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Location Name</th>
                    <th>Region Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div id="location-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <form class="cmxform" ng-submit="locationSubmit(form_data)" ng-model="form_data" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Location</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div ng-if="modalErrors" class="alert alert-danger">
                                    <ul>
                                        <li ng-repeat="error in modalErrors"><% error %></li>
                                    </ul>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Location Name</label>
                                    <input type="text" class="form-text" ng-model="form_data.name" required>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Region Name</label>
                                    <select class="form-control" ng-model="form_data.region_id" ng-options="region.id as region.name for region in regions" required>
                                    <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="form-group form-animate-checkbox col-md-6">
                                    <label class="mb-0">Active</label><br>
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input checkbox"
                                            ng-true-value="'<?php echo \App\Location::FLAG_YES; ?>'"
                                            ng-false-value="'<?php echo \App\Location::FLAG_NO; ?>'"
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
                  <button type="button" ng-if="showDelete" ng-click="deleteLocationConfirmed()" 
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

    app.controller('LocationController', function ($scope, $http, $compile) {

        $scope.addLocation = function(){
            $scope.form_data = $scope.modalErrors  = null;
            $("#location-modal").modal('show');
            $scope.getActiveRegions();
        }

        $scope.locationSubmit = function(form_data){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'location/add-update-location';
            $http.post(url,form_data).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#location-modal").modal('hide');
                    $scope.successMessage = response.data.message;
                    $scope.listLocations();
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

        $scope.editLocation = function(location_id){
            $(".bg_load").show();
            $scope.modalErrors = null;
            $scope.getActiveRegions();
            var url = 'location/get-info/' + location_id;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#location-modal").modal('show');
                    $scope.form_data  = response.data.location;
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
        
        $scope.getActiveRegions = function(){
            $(".bg_load").show();
            var url = 'region/get-active-region';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.regions = response.data.regions;
                } else {
                    alert("Error in fetching active regions");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.deleteLocation = function(location_id){
            $(".bg_load").show();
            $scope.reference_to_delete = location_id;
            $scope.messageToshow = 'You are going to remove this record. Are you sure?';
            $("#delete-confirm").modal('show');
            var url = 'location/can-delete-location/'+location_id;
            $http.get(url).then(function (response) {
                if (response.data.status != 'SUCCESS') {
                    $scope.showDelete = false;
                    $scope.messageToshow = response.data.error;
                }else{
                    $scope.showDelete = true;
                }
                $("#delete-confirm").modal('show');
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.deleteLocationConfirmed = function(){
            $(".bg_load").show();
            var url = 'location/delete/'+$scope.reference_to_delete;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.successMessage = response.data.message;
                    $scope.listLocations();
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
            $scope.errors = $scope.successMessage = $scope.modalErrors = null;
            $scope.listLocations();
        }

        $scope.listLocations = function(){
            $('#location-listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: 'location/list-locations',
                },
                columns: [
                    {data: 'name', name:'name'},
                    {data: 'region.name',data: 'region.name'},
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