@extends('layouts.app')
@section('content')

<div ng-cloak ng-controller="ClickAnalyticsController" class="px-2 py-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h4 class="font-weight-bold text-blue">Click Analytics</h4> 
        </div>
    </div>
    <a href="click-analytics/download-report">
        <button class="btn btn-outline-secondary btn-sm br-40 mr-2 px-3 fs-12 mb-4">Download Report</button>
    </a>
    <div class="responsive-table">
        <table id="click-listing" class="table table-striped table-responsive-sm" 
                width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Link</th>
                    <th>Count</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">

    app.controller('ClickAnalyticsController', function ($scope, $http, $compile) {

        $scope.init = function () {
            $scope.form_data = {};
            $scope.errors = $scope.successMessage = $scope.modalErrors = null;
            $scope.listClicks();
        }

        $scope.listClicks = function(){
            $('#click-listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '/click-analytics/list-clicks',
                },
                columns: [
                    {data: 'link', name:'link',width:'80%'},
                    {data: 'count', searchable: false, orderable: false},
                ],
                createdRow: function (row, data, dataIndex) {
                    $compile(angular.element(row).contents())($scope);
                }
            });
        };

        $scope.downloadFile = function(){

            var url = 'click-analytics/download-report';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
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