@extends('layouts.app')

@section('content')

<div ng-cloak ng-controller="FeedbackController" class="px-2 py-4">
    <h4 class="font-weight-bold text-blue pb-2">Feedback</h4>    
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
        <table id="user-listing" class="table table-striped table-responsive-sm table-responsive-md  table-responsive-lg" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Submitted Date</th>
                    <th>Name</th>
                    <th>Firm Name</th>
                    <th>Position</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <!-- view modal begins -->
        <div id="view-feedback" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content rounded-0">
                <div class="modal-header">
                  <h4 class="modal-title font-weight-bold">Feedback</h4>
                </div>
                <div class="modal-body">
                    <p><% messageToshow %></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default br-40 px-4" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
        </div>
        <!--  view modal ends -->
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">

    app.controller('FeedbackController', function ($scope, $http, $compile) {

        $scope.viewFeedBack = function(feedback_id){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'feedbacks/get-feedback/' + feedback_id;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                     $scope.messageToshow = response.data.feedback.description;
                     $("#view-feedback").modal('show');
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
            $scope.messageToshow = "";
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
                    url: 'feedbacks/list-feedback',
                },
                columns: [
                    {data: 'created_at',name: 'created_at'},
                    {data: 'user_id.name',name: 'userId.name'},
                    {data: 'user_id.firm_name',name: 'userId.firm_name'},
                    {data: 'user_id.position',name: 'userId.position'},
                    {data: 'user_id.contact_number',name: 'userId.contact_number'},
                    {data: 'user_id.email',name: 'userId.email'},
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