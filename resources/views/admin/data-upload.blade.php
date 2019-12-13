@extends('layouts.app')

@section('content')

<div ng-cloak ng-controller="DataUploadController" class="px-2 py-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h4 class="font-weight-bold text-blue">Data Uploads</h4> 
        </div>

    </div>
    <div class="responsive-table">
        <table id="data-upload-listing" class="table table-striped table-responsive-sm" 
                width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
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
                <button type="button" ng-if="showDelete" ng-click="deleteAreaConfirmed()" 
                        class="btn btn-danger br-40 px-4" data-dismiss="modal">Yes</button>
            </div>
            </div>
        </div>
    </div>
    <!--  delete modal ends -->
</div>
@endsection
@push('scripts')
<script type="text/javascript">

    app.controller('DataUploadController', function ($scope, $http, $compile) {

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
            $scope.listDataUploads();
        }

        $scope.listDataUploads = function(){
            $('#data-upload-listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '/data-upload/list',
                },
                columns: [
                    {data: 'file_name', name:'file_name'},
                    {data: 'status_text', searchable: false, orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                createdRow: function (row, data, dataIndex) {
                    $compile(angular.element(row).contents())($scope);
                }
            });
        };

         $scope.downloadFile = function(file_id){

            $scope.file_to_upload = file_id;
            var url = 'data-upload/download/'+$scope.file_to_upload;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.successMessage = response.data.message;
                    window.location.href = "/imports/"+response.data.file_name;
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
        $scope.init();
    });
</script>
@endpush