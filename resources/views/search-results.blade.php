@extends('layouts.app')
@section('content')
<div class="row" ng-cloak ng-controller="DetailListingController">
    <div class="col-md-12 pt-4 pb-3 px-4">

    
        @if(count($firms))
        <h4 class="font-weight-bold text-blue pb-2">Recruiters({{count($firms)}})</h4>
        <div class="row"> 
            
            @foreach($firms as $firm)
            <div class="card-deck ml-1 mb-3" style="width: 17.2rem;">
                <div class="card rounded bg-lightblue border w-100 cursor-pointer" ng-click="saveViewCount({{$firm->id}})">
                    <div class="card-header border-0">
                        @if($firm->logo)
                            <img class="firm-logo" src="{{asset('asset/img/firm-logo').'/'. $firm->logo}}" alt="{{$firm->name}}">
                        @else
                            <strong>{{$firm->name}}</strong>
                        @endif
                        <div class="pull-right">
                            @if($firm->is_verified == \App\RecruitmentFirm::FLAG_YES)
                                <img width="15" src="/img/is_verified_logo.png" alt="Verified"> 
                            @endif  
                            @if($firm->is_specialism == \App\RecruitmentFirm::FLAG_YES)
                                <img width="15" src="/img/specialist_logo.png" alt="Specialist">
                            @endif
                        </div>   
                    </div>
                    <div class="card-body p-3">
                        {!! Str::words( $firm->description, 38, ' ...') !!}
                    </div>
                    <div class="card-footer border-0">
                        <a href="#" class="card-link pull-right">Read more</a>
                        @if(Auth::user())
                            @if(Auth::user()->is_admin == "YES")
                                <small><strong>{{$firm->view_count}}</strong></small>
                            @endif
                        @endif
                    </div>
                </div>
            </div> 
            @endforeach
        </div>
        <div class="modal fade" id="FirmDetailView" tabindex="-1" role="dialog" aria-labelledby="FirmDetailViewTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <img class="firm-logo" ng-src="{{asset('asset/img/firm-logo').'/'}}<%firm.logo%>" alt="Recruiters Firm Logo">
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-blue">Description</h5>
                        <!--- <p>gmk is a London based boutique legal recruitment company, set up in 1998 by its founding directors Lynne McCarroll and Jon Garrett. For the last 20 years, their focus has been purely on the legal recruitment market, specialising in fee-earner recruitment (NQ to partner level) and related non fee earning professionals, including KM/PSLs, Training and Development, and Risk Management Lawyers. They have a team of 10 consultants (many of whom are ex-lawyers), all of whom have been with them for over 5 years, which ensures their clients have continuity in their relationships with individuals at gmk.</p> -->
                        <p class="text-grey" ng-bind-html="firm.description | trust"></p>
                        <h5 class="font-weight-bold py-2">Testimonials</h5>
                        <p class="text-grey" ng-bind-html="firm.testimonials | trust"></p>
                        <!--<div class="row pt-2 text-footer">
                            <div class="col-md-6">
                                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                <span class="text-grey pr-4"><i>Practice Specialism : <% firm.practice_area | areaSpecialismText %></i></span>
                            </div>
                            <div class="col-md-6 text-right">
                                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                <span class="text-grey"><i>Sector Specialism : <% firm.sector | sectorSpecialismText %></i></span>
                            </div>
                        </div>-->
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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

            $('#FirmDetailView').modal('show'); 
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