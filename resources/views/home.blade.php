@extends('layouts.app')
@section('content')
    <div ng-cloak ng-controller="HomeController">
    <div class="row">
        <div class="col-md-12 p-4">
            <div class="landing-page">
                <div class="row">
                    <div class="col-md-12 py-2">
                        <h2><span class="text-muted">Welcome</span> <strong>{{ Auth::user()->name }}</strong>,</h2>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 bg-practice rounded cursor-pointer" onclick="location.href='{{ url('/practice-area-guide') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Practice area guides</h5>
                                <p class="text-light m-0">
                                    Quick and concise overviews of the different practice areas that lawyers work in
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <ion-icon name="arrow-round-forward" class="text-white"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 bg-interview rounded cursor-pointer" onclick="location.href='{{ url('/interview-guide') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Interviewing resources</h5>
                                <p class="text-light m-0">
                                    Helpful resources to use for all levels of interviews from junior to senior level candidates
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <ion-icon name="arrow-round-forward" class="text-white"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 bg-market rounded cursor-pointer" onclick="location.href='{{ url('/reports-analysis') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Market reports and analysis</h5>
                                <p class="text-light m-0">
                                    Range of reports and analysis on the areas of the legal market that are relevant to resourcing.
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <ion-icon name="arrow-round-forward" class="text-white"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 w-100 bg-feedback rounded cursor-pointer" onclick="location.href='{{ url('/feedback-surveys') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Feedback / Surveys</h5>
                                <p class="text-light m-0">
                                    Take part in our surveys relating to diversity, social mobility and attrition.
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <ion-icon name="arrow-round-forward" class="text-white"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 bg-useful rounded cursor-pointer" onclick="location.href='{{ url('/useful-link') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Useful Links</h5>
                                <p class="text-light m-0">
                                    Range of links to different services and sources of information connected to legal resourcing
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <ion-icon name="arrow-round-forward" class="text-white"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-self-stretch mb-4">
                        <div class="card border-0 bg-helpful rounded cursor-pointer" onclick="location.href='{{ url('/helpful-article') }}';">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-white">Helpful articles</h5>
                                <p class="text-light m-0">
                                    Archive of useful articles that we’ve seen over the years that are relevant to legal resourcing.
                                </p>
                            </div>
                            <div class="card-footer border-0 bg-transparent text-right">
                                <ion-icon name="arrow-round-forward" class="text-white"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->newsletter_signup == "NO")
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded shadow">
                            <div ng-hide="!errors" class="alert alert-danger">
                                <a href="#" class="close" ng-click="hideMessage()" aria-label="close">&times;</a>
                                <ul>
                                    <li ng-repeat="error in errors"><% error %></li>
                                </ul>
                            </div>
                            <div ng-hide="!successMessage"  class="alert alert-success">
                                <a href="#" class="close" ng-click="hideMessage()" aria-label="close">&times;</a>
                                <% successMessage %>
                            </div>
                            <div class="card-body pb-0">
                                <h5 class="card-title">Register to receive the recdirec weekly update</h5>
                                <p class="text-muted m-0">A quick and easy to read review of all the main stories in the legal press most relevant to legal resourcing teams.</p>
                            </div>
                            <div class="card-footer border-0 bg-transparent">
                                <a href="#">
                                    <button type="button" class="btn btn-sm btn-form br-40 px-4"
                                    ng-click="newletterRegister()">Register</button>
                                </a>
                            </div>
                        </div>  
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-md-12">
                        <a href="https://www.jmangroup.com/" target="_blank">
                            <img src="/img/jman-add.jpg">
                        </a>
                    </div>
                </div>
                @endif
                
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
            var url = 'user/newsletter-register';
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