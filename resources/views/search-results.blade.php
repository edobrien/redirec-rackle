@extends('layouts.app')
@section('content')
<div class="row" ng-cloak ng-controller="DetailListingController">
    <div class="col-md-12 pt-4 pb-3 px-4">
        @if(count($firms))
        <h4 class="font-weight-bold text-blue pb-2">Recruiters({{count($firms)}})</h4>
        <div class="row">
            <div class="col-md-3 search-results">
                @foreach($firms as $firm)
                <div class="card bg-lightgrey rounded-0 border-0 mb-2 cursor-pointer" ng-click="saveViewCount({{$firm->id}})">
                    <div class="card-body p-2 pl-3">
                        <p class="m-0 user-name" data-toggle="tooltip" data-placement="top" title="{{$firm->name}}">
                            {{$firm->name}}  
                            <div class="pull-right" style="margin-top:-21px">
                                @if($firm->is_verified == \App\RecruitmentFirm::FLAG_YES)
                                <img src="/img/is_verified_logo.png" height="17" alt="Verified"> 
                                @endif  
        
                                @if($firm->is_specialism == \App\RecruitmentFirm::FLAG_YES)
                                <img src="/img/specialist_logo.png" height="17" alt="Specialist"> 
                                @endif
                            </div>                          
                        </p>
                          
                       
                      
                        <small class="text-muted mb-0">{{$firm->location}}</small>
                        @if(Auth::user()->is_admin == "YES")
                        <small class="text-blue pull-right"><strong>{{$firm->view_count}}</strong></small>
                       @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div ng-show="!firm" class="col-md-9 d-flex justify-content-center mt-8">
                <h4 class="font-weight-bold text-grey"> Click on recruiters to see detailed information about the recruitment firm’s:<br/><br/>
                    <ul> 
                        <li>Background</li>
                        <li>Services offered</li>
                        <li>Specialisms – Practice area or sectors</li>
                        <li>Market knowledge and reach</li>
                        <li>Charity partners / CSR activities</li>
                    </ul>
                </h4>
            </div>
               
            <div class="col-md-9 search-results" ng-show="firm">
                <div class="firm-header">
                    <h5 class="font-weight-bold"><% firm.name %></h5>
                    <img height="46" class="firm-logo" ng-src="{{asset('asset/img/firm-logo').'/'}}<%firm.logo%>" alt="Firm Logo">
                </div>
                <p class="text-grey" ng-bind-html="firm.description | trust"></p>
                <h5 class="font-weight-bold py-2">Testimonials</h5>
                <p class="text-grey" ng-bind-html="firm.testimonials | trust"></p>
                <h5 class="font-weight-bold py-2">Facts and Figures</h5>
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <h6 class="font-weight-bold text-grey">Office Location</h6>
                        <ul class="text-grey pl-4">
                            <li class="pb-1" ng-repeat="location in firm.firm_location"><% location.location.name %></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <h6 class="font-weight-bold text-grey">Services</h6>
                        <ul class="text-grey pl-4">
                            <li class="pb-1" ng-repeat="service in firm.firm_service"><% service.service.name %></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <h6 class="font-weight-bold text-grey">Types of recruitment</h6>
                        <ul class="text-grey pl-4">
                            <li class="pb-1" ng-repeat="type in firm.firm_recruitment_type"><% type.recruitment_type.name %></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <h6 class="font-weight-bold text-grey">Clients</h6>
                        <ul class="text-grey pl-4">
                            <li class="pb-1" ng-repeat="client in firm.firm_client"><% client.client_location %></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <h6 class="font-weight-bold text-grey">Practice area specialisms</h6>
                        <ul class="text-grey pl-4">
                            <li class="pb-1" ng-repeat="area in firm.firm_practice_area" 
                                ng-show="area.practice_area.type!='GENERAL'"><% area.practice_area.name %></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <h6 class="font-weight-bold text-grey">Private Practice Sector specialisms</h6>
                        <ul class="text-grey pl-4">
                            <li class="pb-1" ng-repeat="sector in firm.firm_sector" 
                                ng-show="sector.sector.type=='PRIVATE_PRACTICE'"><% sector.sector.name %>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <h6 class="font-weight-bold text-grey">Inhouse Sector specialisms</h6>
                        <ul class="text-grey pl-4">
                            <li class="pb-1" ng-repeat="sector in firm.firm_sector" 
                                ng-show="sector.sector.type=='INHOUSE'"><% sector.sector.name %>
                        </ul>
                    </div>
                </div>
                <h5 class="font-weight-bold py-2">Regions recruited for</h5>
                <ul class="text-grey pl-4">
                    <li class="pb-2" ng-repeat="region in firm.firm_region"><% region.location.region.name %> - <% region.location.name %></li>
                </ul>
                <h5 class="font-weight-bold pb-2">Contact Details</h5>
                <div class="row">
                    <div class="col-md-6 col-lg-4" ng-repeat="location in firm.firm_location">
                        <ul class="text-grey list-style-none pl-0">
                            <li class="pb-1">
                                <h6 class="font-weight-bold text-grey"><% location.location.name %></h6>
                                <% location.contact_name %> <br> <% location.telephone %> <br> <% location.email %>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row pt-2 text-footer">
                    <div class="col-md-6">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        <span class="text-grey pr-4"><i>Practice Specialism : <% firm.practice_area | areaSpecialismText %></i></span>
                    </div>
                    <div class="col-md-6 text-right">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        <span class="text-grey"><i>Sector Specialism : <% firm.sector | sectorSpecialismText %></i></span>
                    </div>
                </div>
                <div class="row pt-2 text-footer">
                    <div class="col-md-6">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <span class="text-grey"><% firm.location %></span>
                    </div>
                    <div class="col-md-6 text-right">
                        <i class="fa fa fa-globe" aria-hidden="true"></i>
                        <a href="http://<% firm.website_link %>" target="_blank" class="text-grey"><% firm.website_link %></a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-12">
                <div class="no-search-results d-flex flex-column align-items-center justify-content-center">
                    <h2>Sorry, No Search results found</h2>
                    <p class="pb-3">Please try searching with another term</p>
                    <img src="/img/search-firm.png" height="140">    
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    
    var specialism = {"GENERAL":"Generalist", 
                        "SPECIAL":"Specialist", 
                        "GENERAL_AND_SPECIAL":"Generalist & Specialist"};

    app.filter("trust", ['$sce', function($sce) {
      return function(htmlCode){
        return $sce.trustAsHtml(htmlCode);
      }
    }]);

    app.filter('areaSpecialismText', function() {
        return function(practice_area){
            txt = specialism[practice_area];
            if(txt){
                return txt;
            }
            return practice_area;
        };        
    });

    app.filter('sectorSpecialismText', function() {
        return function(sector){
            txt = specialism[sector];
            if(txt){
                return txt;
            }
            return sector;
        };        
    });

    app.controller('DetailListingController', function ($scope, $http, $compile) {

        $scope.saveViewCount = function(firm_id){
            $(".bg_load").show();
            $scope.modalErrors = null;$scope.firm = {};
            var url = 'firm-view-count/'+firm_id;
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.firm = response.data.firm;
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

        $scope.init = function () {
            $scope.form_data = {};
            $scope.errors = $scope.successMessage = $scope.modalErrors = null;
        }

        $scope.init();
    });
</script>
@endpush