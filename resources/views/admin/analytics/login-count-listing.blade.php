@extends('layouts.app')
@section('content')

<div ng-cloak ng-controller="LoginCountAnalyticsController" class="px-2 py-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h4 class="font-weight-bold text-blue">Login Logs</h4> 
        </div>
    </div>
    <div class="responsive-table">
        <table id="click-listing" class="table table-striped table-responsive-sm" 
                width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Firm Name</th>
                    <th>Position</th>
                    <th>Last Login</th>
                    <th>Count</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">

    app.controller('LoginCountAnalyticsController', function ($scope, $http, $compile) {

        $scope.init = function () {
            $scope.listClicks();
        }

        $scope.listClicks = function(){
            $('#click-listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '/login-count/list-user-count',
                },
                columns: [
                    {data: 'name', name:'name'},
                    {data: 'firm_name', name:'firm_name'},
                    {data: 'position', name:'position'},
                    {data: 'last_login_at', name:'last_login_at'},
                    {data: 'successful_login_count', name:'successful_login_count'},
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