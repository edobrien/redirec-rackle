@extends('layouts.app')
@section('content')
<div class="px-2 py-4 upload" ng-cloak ng-controller="UploadController">
    <h4 class="font-weight-bold text-blue pb-2">Upload File</h4>
    <p class="text-grey">Please download the below template and upload the filled template to add any new firm details to the application.</p>
    <a href="/download-template">
        <button class="btn btn-outline-secondary btn-sm br-40 mr-2 px-3 fs-12 mb-4">Download Template</button>
    </a>
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
    <div ng-if="modalErrors" class="alert alert-danger col-md-12">
        <a href="#" class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
        <ul class="pl-2 mb-0">
            <li ng-repeat="error in modalErrors"><% error %></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form ng-submit="firmSubmit(form_data)" ng-model="form_data" method="post">
                <input type="file" class="form-text" 
                    ng-model="form_data.upload_excel" id="upload_excel" file-model="upload_excel" 
                    accept=".xlsx,.xls">
                <div class="dropzone mt-3 d-flex flex-column align-items-center justify-content-center">
                    <img src="img/file-upload.png" alt="Recdirec" width="150" class="mb-4">
                    <h3 class="text-grey font-weight-bold mb-3">Drag and drop or click here</h3>
                    <h4 class="text-grey mb-4">to upload data (max 2MB)</h4>
                </div>
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
  $('form input').change(function () {
    $('form div').text(this.files[0].name);
  });
});
</script>
@endsection
@push('scripts')
<script type="text/javascript">

    app.controller('UploadController', function ($scope, $http, $compile, fileUpload) {

        $scope.firmSubmit = function(form_data){
            $(".bg_load").show();
            $scope.modalErrors = null;
            form_data.upload_excel = $scope.upload_excel;
            var url = '/upload-firms';
            fileUpload.uploadFileToUrl(form_data, url).then(function(response){
                if (response.status == 'SUCCESS') {
                    $(".bg_load").hide();
                    $scope.form_data = {};
                    $('#upload_excel').val('');
                    $('form div').text('');
                    $scope.successMessage = response.message;
                }else{
                    var errors = [];
                    $.each(response.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.modalErrors = errors;
                    $('html, body').animate({scrollTop : 0},400);
                    $(".bg_load").hide();
                }
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
        }
        $scope.init();
    });

    app.service('fileUpload', ['$http', function ($http) {
        this.uploadFileToUrl = function(form_data, url){
            var fd = new FormData();
            for (var key in form_data) {
                fd.append(key, form_data[key]);
            }
            return $http({
                url: url,
                method: "POST",
                data: fd,
                headers: {'Content-Type': undefined}
            }).then(function(response) {
                return response.data;                    
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
                            $('#upload_excel').val('');
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