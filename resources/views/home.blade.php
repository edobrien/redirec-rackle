@extends('layouts.app')
@section('content')
<div ng-cloak ng-controller="HomeController">
    <div class="row">
        <div class="col-md-12 p-4">
            <div class="landing-page">
             @if (Auth::user())   
                <div class="row">
                    <div class="col-md-12 py-2">
                        <h2><span class="text-muted">Welcome</span> <strong>{{ Auth::user()->name }}</strong>,</h2>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 bg-helpful rounded cursor-pointer" onclick="location.href='{{ url('/practice-area-guide') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Recruitment Market Overviews</h5>
                                <p class="text-light m-0">
                                    Overview of all the recruitment activity happening in all the different practice areas and inhouse sectors.  Plus, inside views from specialist recruiters.
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <i class="icon ion-md-arrow-round-forward text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 bg-useful rounded cursor-pointer" onclick="location.href='{{ url('/useful-link') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Job Opportunities</h5>
                                <p class="text-light m-0">
                                    search for current opportunities where your practice area skill sets are needed.
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <i class="icon ion-md-arrow-round-forward text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 bg-feedback rounded cursor-pointer" onclick="location.href='{{ url('/interview-guide') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">General Insights/Helpful Advice</h5>
                                <p class="text-light m-0">
                                    helpful insights and advice to help you manage all stages of your legal career.
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <i class="icon ion-md-arrow-round-forward text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 w-100 bg-market rounded cursor-pointer" onclick="location.href='{{ url('/reports-analysis') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Market Reports and Analysis</h5>
                                <p class="text-light m-0">
                                    Range of reports and analysis to help you manage your career within the legal sector.
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <i class="icon ion-md-arrow-round-forward text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 bg-interview rounded cursor-pointer" onclick="location.href='{{ url('/feedback-surveys') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Surveys/Feedback</h5>
                                <p class="text-light m-0">
                                    Take part in our surveys relating to diversity, social mobility, attrition and other resourcing related matters. Provide feedback / suggestions on the site.
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <i class="icon ion-md-arrow-round-forward text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 bg-practice rounded cursor-pointer" onclick="location.href='{{ url('/helpful-article') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Blog Articles</h5>
                                <p class="text-light m-0">
                                    view the latest blog articles from The Rackle and guest bloggers.
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <i class="icon ion-md-arrow-round-forward text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="text-dec-none" href="https://www.jmangroup.com/">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded bg-green">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8 col-md-12 py-4">
                                        <h3 class="text-g pl-3 mb-0">Empowering our clients to enhance business outcomes through data and analytics</h3>
                                    </div>
                                    <div class="col-lg-4 col-md-12 d-flex align-items-center justify-content-center">
                                        <img src="/img/jman-group-w.png" height="45">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
                {{--  @if(Auth::user()->newsletter_signup == "NO")  --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded shadow">
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
                            {{--  <div class="card-body pb-0">
                                <h5 class="card-title">Register to receive the recdirec weekly update</h5>
                                <p class="text-muted m-0">A quick and easy to read review of all the main stories in the legal press most relevant to legal resourcing teams.</p>
                            </div>
                            <div class="card-footer border-0 bg-transparent">
                                <a href="#">
                                    <button type="button" class="btn btn-sm btn-form br-40 px-4"
                                    ng-click="newletterRegister()">Register</button>
                                </a>
                            </div>  --}}
                        </div>  
                    </div>
                </div>
                {{--  @else  --}}
                <div class="row">
                    <div class="col-md-12">
                        <!-- <div class="card border-0 rounded shadow bg-green pb-0">
                            <div class="card-body py-0">
                                <div class="row">
                                    <div class="col-lg-8 col-md-12 py-3">
                                        <h5 class="card-title text-white">JMAN GROUP IS A TECHNOLOGY-ENABLED MANAGEMENT CONSULTANCY.</h5>
                                        <p class="text-white">Recognised by Financial Times as one of the UK’s leading Management Consultancies in 2018.</p>
                                        <a href="https://www.jmangroup.com/" target="_blank">
                                            <button type="button" class="btn btn-sm btn-form br-40 px-4 py-2">Get Started</button>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-12 text-lg-right text-center">
                                        <img src="/img/finanacial-times-logo-2019.png" height="130">
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!--<img src="/img/Legal_Monitor_Banner.jpg" class="w-100" alt="CB_Conference Banner">-->
                    </div>
                </div>
                {{--  @endif  --}}
                
                <!-- modal begins -->
                <div id="register-confirm" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content rounded-0">
                        <div class="modal-header">
                          <h4 class="modal-title font-weight-bold">Newsletter</h4>
                        </div>
                        <div class="modal-body">
                            <p><% messageToshow %></p>
                        </div>
                        <div class="modal-footer border-0">
                          <button type="button" class="btn btn-default br-40 px-4" 
                                onclick="location.reload();" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                </div>
                <!--  modal ends -->
                <!-- <hr class="mb-4">
                <h2 class="text-dark">Register to receive the Recdirec weekly update</h2>
                <h5 class="text-grey pb-2">A quick and easy to read review of all the main stories in the legal press most relevant to legal resourcing teams.</h5>
                <a href="#">
                    <button type="button" class="btn bg-darkblue br-40 px-4">Register</button>
                </a> -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    
    app.controller('HomeController', function ($scope, $http, $compile) {

        $scope.newletterRegister = function(){
            $scope.messageToshow = null;
            $(".bg_load").show();
            var url = '/user/newsletter-register';
            $http.post(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $(".bg_load").hide();
                    $scope.messageToshow = response.data.message;
                    $("#register-confirm").modal('show');            
                } else {
                    var errors = [];
                    $.each(response.data.errors, function (key, value) {
                        errors.push(value);
                    });
                    $scope.errors = errors;
                    $(".bg_load").hide();
                }
            });
        }
        
        $scope.hideMessage = function(){
            if($scope.successMessage){
                delete $scope.successMessage;
            }
            if($scope.errors){
                delete $scope.errors;
            }
        }

        $scope.init = function () {
            $scope.form_data = {};
            $scope.successMessage = $scope.errors = null;
        }

        $scope.init();
    });

</script>
@endpush