@extends('layouts.app')

@section('content')

<div ng-cloak ng-controller="UserController" class="px-2 py-4 users">
    <h4 class="font-weight-bold text-blue pb-2">Users</h4>    
    <div class="responsive-table">
        <div class="row">
            <div class="col-md-3 mb-3">
                <select class="form-control" ng-change="listUsers()" ng-model="filter_data.status">
                    <option value="">All</option>
                    <option value="<?php echo \App\User::FLAG_YES; ?>">Active</option>
                    <option value="<?php echo \App\User::FLAG_NO; ?>">In Active</option>
                </select>
            </div>
        </div>
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
        <table id="user-listing" class="table table-striped table-responsive-sm table-responsive-md" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="px-2">Name</th>
                    <th class="px-2">Firm Name</th>
                    <th class="px-2">Position</th>
                    <th class="px-2">Contact Number</th>
                    <th class="px-2">Email</th>
                    <th class="px-2">Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div id="user-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <form class="cmxform" ng-submit="userSubmit(form_data)" ng-model="form_data" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">User</h4>
                        </div>
                        <div class="modal-body">
                            <div ng-if="modalErrors" class="alert alert-danger col-md-12">
                                <a href="#" class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
                                <ul class="pl-2 mb-0">
                                    <li ng-repeat="error in modalErrors"><% error %></li>
                                </ul>
                            </div>
                            <div class="form-row">
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Name</label>
                                    <input type="text" class="form-text" ng-model="form_data.name" required>
                                </div>
                                <div class="form-group signup form-animate-text col-md-6">
                                    <label class="mb-0">Firm name</label>
                                    <input type="text" class="form-text" ng-model="form_data.firm_name" required>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Position</label>
                                    <input type="text" class="form-text" ng-model="form_data.position" required>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Contact Number</label>
                                    <input type="phone" class="form-text" ng-model="form_data.contact_number" required>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Email</label>
                                    <input type="email" class="form-text" ng-model="form_data.email" required>
                                </div>
                                <div class="form-group form-animate-checkbox col-md-6">
                                    <label class="mb-0">Active</label><br>
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input checkbox"
                                            ng-true-value="'<?php echo \App\User::FLAG_YES; ?>'"
                                            ng-false-value="'<?php echo \App\User::FLAG_NO; ?>'"
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
                  <button type="button" ng-if="showDelete" ng-click="deleteUserConfirmed()" 
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

    app.controller('UserController', function ($scope, $http, $compile) {

        $scope.userSubmit = function(form_data){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'user/update';
            $http.post(url,form_data).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#user-modal").modal('hide');
                    $scope.successMessage = response.data.message;
                    $scope.listUsers();
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

        $scope.editUser = function(user_id){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'user/get-info/' + user_id;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#user-modal").modal('show');
                    $scope.form_data  = response.data.user;
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
        
        $scope.deleteUser = function(user_id){
            $scope.reference_to_delete = user_id;
            $scope.messageToshow = 'You are going to remove this record. Are you sure?';
            $scope.showDelete = true;
            $("#delete-confirm").modal('show');
        }

        $scope.deleteUserConfirmed = function(){
            $(".bg_load").show();
            var url = 'user/delete/'+$scope.reference_to_delete;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.showDelete = false;
                    $scope.listUsers();
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
            $scope.filter_data =  $scope.form_data = {};
            $scope.filter_data.status = $scope.messageToshow = "";
            $scope.errors = $scope.successMessage = $scope.modalErrors = null;
            $scope.listUsers();
        }

        $scope.listUsers = function () {
            $('#user-listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: 'user/list-users/'+$scope.filter_data.status,
                },
                columns: [
                    {data: 'name'},
                    {data: 'firm_name'},
                    {data: 'position'},
                    {data: 'contact_number'},
                    {data: 'email'},
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

</script>
@endpush