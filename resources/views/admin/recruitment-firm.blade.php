@extends('layouts.app')
@section('content')
<div ng-cloak ng-controller="FirmController" class="px-2 py-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h4 class="font-weight-bold text-blue">Recruitment Firm</h4> 
        </div>
        <div class="col-md-4">
            <button ng-click="addFirm()" title="Add Firm" title="Add Firm" class=" btn btn-circle btn-mn bg-darkblue pull-right rounded-0">
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
        <table id="firm-listing" class="table table-striped table-responsive-sm table-responsive-md  table-responsive-lg" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Telephone</th>
                    <th>Contact Name</th>
                    <th>View Count</th>
                    <th>Firm Size</th>
                    <th>Establihsed Year</th>
                    <th>IsActive</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div id="firm-modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <form class="cmxform" ng-submit="firmSubmit(form_data)" ng-model="form_data" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold">Recruitment Firm</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div ng-if="modalErrors" class="alert alert-danger col-md-12">
                                    <a href="#"  class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
                                    <ul class="pl-2 mb-0">
                                        <li ng-repeat="error in modalErrors"><% error %></li>
                                    </ul>
                                </div>
                                <div ng-hide="!successLogoMessage"  class="alert alert-success col-md-12">
                                    <a href="#"  class="close pr-2" ng-click="hideMessage()" aria-label="close">&times;</a>
                                    <% successLogoMessage %>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Name</label>
                                    <input type="text" class="form-text" ng-model="form_data.name" required>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Website Link</label>
                                    <input type="text" class="form-text" ng-model="form_data.website_link" required>
                                </div>
                                <div class="form-group form-animate-text col-md-12">
                                    <label class="mb-0">Description</label><br>
                                    <textarea ng-model="form_data.description" name="description" 
                                    required></textarea>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Telephone</label>
                                    <input type="text" class="form-text" ng-model="form_data.telephone" required>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Contact Name</label>
                                    <input type="text" class="form-text" ng-model="form_data.contact_name" required>
                                </div>
                                <div class="form-group form-animate-text col-md-12">
                                    <label class="mb-0">Testimonial</label><br>
                                    <textarea ng-model="form_data.testimonial" name="overview" 
                                    required></textarea>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Size</label>
                                    <select class="form-control" ng-model="form_data.firm_size" required>
                                        <option value="">Select</option>
                                        <option value="<?php echo \App\RecruitmentFirm::SIZE_SMALL; ?>">
                                        <?php echo \App\RecruitmentFirm::SIZE_SMALL_TEXT; ?></option>
                                        <option value="<?php echo \App\RecruitmentFirm::SIZE_MEDIUM; ?>">
                                        <?php echo \App\RecruitmentFirm::SIZE_MEDIUM_TEXT; ?></option>
                                        <option value="<?php echo \App\RecruitmentFirm::SIZE_LARGE; ?>">
                                        <?php echo \App\RecruitmentFirm::SIZE_LARGE_TEXT; ?></option>
                                        <option value="<?php echo \App\RecruitmentFirm::SIZE_SMALL_MEDIUM; ?>">
                                            <?php echo \App\RecruitmentFirm::SIZE_SMALL_MEDIUM_TEXT; ?></option>
                                        <option value="<?php echo \App\RecruitmentFirm::SIZE_SMALL_LARGE; ?>">
                                            <?php echo \App\RecruitmentFirm::SIZE_SMALL_LARGE_TEXT; ?></option>
                                        <option value="<?php echo \App\RecruitmentFirm::SIZE_MEDIUM_LARGE; ?>">
                                            <?php echo \App\RecruitmentFirm::SIZE_MEDIUM_LARGE_TEXT; ?></option>
            
                                    </select>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Location</label>
                                    <input type="text" class="form-text" ng-model="form_data.location" required>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Practice Area</label>
                                    <select class="form-control" ng-model="form_data.practice_area" required>
                                        <option value="">Select</option>
                                        <option value="<?php echo \App\PracticeArea::AREA_GENERAL; ?>">
                                        <?php echo \App\PracticeArea::AREA_GENERAL_TEXT; ?></option>
                                        <option value="<?php echo \App\PracticeArea::AREA_SPECIAL; ?>">
                                        <?php echo \App\PracticeArea::AREA_SPECIAL_TEXT; ?></option>
                                        <option value="<?php echo \App\PracticeArea::AREA_GENERAL_AND_SPECIAL; ?>">
                                            <?php echo \App\PracticeArea::AREA_GENERAL_AND_SPECIAL_TEXT; ?></option>
                                    </select>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Sector</label>
                                    <select class="form-control" ng-model="form_data.sector" required>
                                        <option value="">Select</option>
                                        <option value="<?php echo \App\Sector::SECTOR_GENERAL; ?>">
                                            <?php echo \App\Sector::SECTOR_GENERAL_TEXT; ?></option>
                                        <option value="<?php echo \App\Sector::SECTOR_SPECIAL; ?>">
                                            <?php echo \App\Sector::SECTOR_SPECIAL_TEXT; ?></option>
                                        <option value="<?php echo \App\Sector::SECTOR_GENERAL_AND_SPECIAL; ?>">
                                            <?php echo \App\Sector::SECTOR_GENERAL_AND_SPECIAL_TEXT; ?></option>
                                       
                                    </select>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">Established Year</label>
                                    <select class="form-control" ng-model="form_data.established_year">
                                        <option value="">Select</option>
                                        <option ng-repeat="x in established_years"><% x %></option>
                                    </select>
                                </div>
                                <div class="form-group form-animate-text col-md-6">
                                    <label class="mb-0">General Ranking</label>
                                    <input type="number" class="form-text" ng-model="form_data.general_ranking" required>
                                    </select>
                                </div>
                                <div class="form-group form-animate-checkbox col-md-6">
                                    <label class="mb-0">Active</label><br>
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input checkbox"
                                            ng-true-value="'<?php echo \App\RecruitmentFirm::FLAG_YES; ?>'"
                                            ng-false-value="'<?php echo \App\RecruitmentFirm::FLAG_NO; ?>'"
                                            ng-model="form_data.is_active" 
                                        />
                                        <span class="switch-label" data-on="Yes" data-off="No"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </div>
                                <div class="form-group form-animate-checkbox col-md-6">
                                    <label class="mb-0">Verified</label><br>
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input checkbox"
                                            ng-true-value="'<?php echo \App\RecruitmentFirm::FLAG_YES; ?>'"
                                            ng-false-value="'<?php echo \App\RecruitmentFirm::FLAG_NO; ?>'"
                                            ng-model="form_data.is_verified" 
                                        />
                                        <span class="switch-label" data-on="Yes" data-off="No"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </div>
                                <!-- current image -->
                                <div class="form-group col-md-6 firm-logo-section" 
                                        ng-if="form_data.logo">
                                    <div>
                                        <div>
                                            <span>Current Logo</span>
                                            <i class="fa fa-trash-o pl-4 ml-1" ng-click="deleteLogo(form_data.id)" aria-hidden="true"></i>
                                        </div>
                                        <div><img style="height:125px;width: 125px" ng-src="{{asset('asset/img/firm-logo').'/'}}<%form_data.logo%>" alt="Logo not available"></div>
                                    </div>
                                </div>
                                <!-- current image -->
                                <div class="form-group col-md-12">
                                    <label class="mb-0">Logo</label>
                                    <input type="file" class="form-text" 
                                        ng-model="form_data.logo" id="logo" file-model="logo">
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
                  <button type="button" ng-if="showDelete" ng-click="deleteFirmConfirmed()" 
                          class="btn btn-danger br-40 px-4" data-dismiss="modal">Yes</button>
                </div>
              </div>
            </div>
        </div>
        <!--  delete modal ends -->

        <!-- delete Logo Modal begins -->
        <div id="delete-logo" class="modal fade" role="dialog">
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
                  <button type="button" ng-click="deleteLogoConfirmed()" 
                          class="btn btn-danger br-40 px-4" data-dismiss="modal">Yes</button>
                </div>
              </div>
            </div>
        </div>
        <!--  delete Logo Modal ends -->
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
<script type="text/javascript">

    app.controller('FirmController', function ($scope, $http, $compile, fileUpload) {

        $scope.addFirm = function(){
            $scope.form_data = $scope.modalErrors  = null;
            $("#firm-modal").modal('show');
            CKEDITOR.instances["description"].setData('');
            CKEDITOR.instances["overview"].setData('');
        }

        $scope.firmSubmit = function(form_data){
            $(".bg_load").show();
            $scope.modalErrors = null;
            form_data.logo = $scope.logo;
            $scope.form_data.description = CKEDITOR.instances["description"].getData();
            $scope.form_data.overview = CKEDITOR.instances["overview"].getData();
            var url = 'recruitment-firm/add-update-firm';
            fileUpload.uploadFileToUrl(form_data, url).then(function(response){
                if (response.status == 'SUCCESS') {
                    $("#firm-modal").modal('hide');
                    $(".bg_load").hide();
                    $scope.form_data = {};
                    $('#logo').val('');
                    $scope.successMessage = response.message;
                    $scope.listFirms();
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

        $scope.editFirm = function(firm_id){
            $(".bg_load").show();
            $scope.modalErrors = null;
            var url = 'recruitment-firm/get-info/' + firm_id;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $("#firm-modal").modal('show');
                    $scope.form_data  = response.data.firm;
                    CKEDITOR.instances["description"].setData($scope.form_data.description);
                    CKEDITOR.instances["overview"].setData($scope.form_data.testimonials);
                } else {
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.modalErrors = errors;
                    $('html, body').animate({scrollTop : 0},400);
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }
        
        $scope.deleteFirm = function(firm_id){
            $scope.reference_to_delete = firm_id;
            $scope.messageToshow = 'You are going to remove this record. Are you sure?';
            $("#delete-confirm").modal('show');
            var url = 'recruitment-firm/can-delete-firm/'+firm_id;
            $http.get(url).then(function (response) {
                if (response.data.status != 'SUCCESS') {
                    $scope.showDelete = false;
                    $scope.messageToshow = response.data.error;
                }else{
                    $scope.showDelete = true;
                }
                $("#delete-confirm").modal('show');
            });
        }

        $scope.deleteFirmConfirmed = function(){
            $(".bg_load").show();
            var url = 'recruitment-firm/delete/'+$scope.reference_to_delete;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.successMessage = response.data.message;
                    $scope.listFirms();
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
            if($scope.successLogoMessage){
                delete $scope.successLogoMessage;
            }
        }

        $scope.graduationYears = function(){
            $scope.grad_years = {};
            var year = new Date().getFullYear();
            var range = [];
            for (var i = 1980; i < (year+1); i++) {
                range.push(i);
            }
            $scope.established_years = range;
        };

        $scope.init = function () {
            $scope.form_data = {};
            $scope.errors = $scope.successMessage = $scope.modalErrors = $scope.successLogoMessage = null;
            $scope.listFirms();
            $scope.graduationYears();
            if (!CKEDITOR.instances["description"]){
                CKEDITOR.replace('description');
            }
            if (!CKEDITOR.instances["overview"]){
                CKEDITOR.replace('overview');
            }
        }

        $scope.listFirms = function(){
            $('#firm-listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: 'recruitment-firm/list-firm',
                },
                columns: [
                    {data: 'name', name:'name'},
                    {data: 'telephone', name:'telephone'},
                    {data: 'contact_name', name:'contact_name'},
                    {data: 'view_count', name:'view_count'},
                    {data: 'size_text', name:'size_text'},
                    {data: 'established_year', name:'established_year'},
                    {data: 'status_text', searchable: false, orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                createdRow: function (row, data, dataIndex) {
                    $compile(angular.element(row).contents())($scope);
                }
            });
        };
        $scope.deleteLogo = function(id){
            $scope.reference_to_delete_logo = id;
            $scope.messageToshow = 'You are going to remove this logo. Are you sure?';
            $("#delete-logo").modal('show');
        }
        $scope.deleteLogoConfirmed = function(){
            $(".bg_load").show();
            var url = 'recruitment-firm/delete-logo/'+$scope.reference_to_delete_logo;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.successLogoMessage = response.data.message;
                    $scope.form_data.logo = null;
                    $scope.logo = null;
                    $('#logo').val('');
                    $(".firm-logo-section").hide();
                }else{
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.errors = errors;
                }
            }).finally(function(){
                $(".bg_load").hide();
                $("#firm-modal").animate({ scrollTop: 0 }, "slow");
                $("#firm-modal").css("overflow-y", "auto");
            });
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
                            $('#logo').val('');
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