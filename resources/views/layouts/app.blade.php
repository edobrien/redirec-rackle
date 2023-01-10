<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"content="width=device-width, initial-scale=1">
     
    <!-- CSRF Token -->
    <meta name="csrf-token"content="{{ csrf_token() }}">
    <link rel="icon"href="../img/fav.png">
    <title>The Rackle</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}"rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}"rel="stylesheet">
     
    <!-- Fonts -->
    <link rel="dns-prefetch"href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito"rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"rel="stylesheet">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
     
    <!-- Script - Jquery, Popper and Bootstrap -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="{{ asset('js/app.js') }}"defer></script>
    <script src="{{ asset('js/jquery.cookie.js') }}"></script>

     
    <!-- Used for google recaptcha-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
     
    <!-- Used for yajra datatables-->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"defer></script>
     
    <!-- Angular -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
     
    <!-- Search Firm -->
    <script src="{{ asset('js/firm-search.js') }}"></script>
    @yield('head')
    @stack('scripts')
</head>
<body>
    <div id="app" ng-app="recdirecApp">
        <nav class="navbar navbar-expand-sm navbar-light navbar-border shadow static-top">
            <div class="container-fluid">
                <a class="navbar-brand py-0" href="{{ url('/home') }}">
                    <!--{{ config('app.name', 'THE RACKLE') }}-->
                    <!--<img src="../img/logo-header.png" alt="The Rackle">-->
                    <h4 class="mb-0 text-white"><span>THE</span> <span class="text-blue">RACKLE</span></h4>
                </a>
                <div class="d-flex">
                    <button class="navbar-toggler sidebar-button" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="fa fa-th-large"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item {{ Request::is('practice-area-guide') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/practice-area-guide') }}">Market Overviews</a>
                        </li>
                        @if (Auth::user())
                        <li class="nav-item {{ Request::is('useful-link') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/useful-link') }}">Jobs</a>
                        </li>
                        @else
                        <li class="nav-item {{ Request::is('useful-link') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('login') }}">Jobs</a>
                        </li>
                        @endif
                        <li class="nav-item {{ Request::is('interview-guide') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/interview-guide') }}">Advice</a>
                        </li>
                        <li class="nav-item {{ Request::is('reports-analysis') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/reports-analysis') }}">Reports</a>
                        </li>
                        @if (Auth::user())
                        <li class="nav-item {{ Request::is('feedback-surveys') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/feedback-surveys') }}">Surveys</a>
                        </li>
                        @else
                        <li class="nav-item {{ Request::is('feedback-surveys') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('login') }}">Surveys</a>
                        </li>
                        @endif
                        
                        <li class="nav-item {{ Request::is('helpful-article') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/helpful-article') }}">Blog</a>
                        </li>
                        <!-- Authentication Links -->
                        @if(Auth::user() && (Auth::user()->is_active == "No"))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @elseif(Auth::user())
                        <li class="nav-item dropdown">
                                <!-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a> -->

                                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-ellipsis-h pt-1 admin-icon"></i>
                                </a>

                                <div class="dropdown-menu rounded-0 mddp dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->is_admin == "YES")
                                    <a class="mt-1" style="padding: .5rem 2rem .5rem 1rem !important;">
                                        <span style="font-size: large;" class="text-blue"><strong>{{ Auth::user()->name }}</strong></span>
                                        <a style="padding:15px" class="pull-right text-muted" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <br>
                                        <small style="padding:15px" class="text-muted">Administrator</small>
                                    </a>
                                    <hr class="style-dashed">
                                    <div class="row py-2 w-640">
                                        <div class="col-md-4 border-right pl-4">
                                            <ul class="list-group">
                                                <li class="list-style">
                                                    <a class="dropdown-item text-muted {{ Request::is('users') ? 'active' : '' }}" href="{{ url('/users') }}">
                                                        Users
                                                    </a>
                                                </li>
                                                <li class="d-mob-show">
                                                    <a class="dropdown-item {{ Request::is('practice-area-sections') ? 'active' : '' }}" href="{{ url('/practice-area-sections') }}">
                                                        Practice area sections
                                                    </a>
                                                </li>
                                                <li class="d-mob-show">
                                                    <a class="dropdown-item {{ Request::is('interview-guide-sections') ? 'active' : '' }}" href="{{ url('/interview-guide-sections') }}"> 
                                                        Interview sections
                                                    </a>
                                                </li>
                                                <li class="d-mob-show">
                                                    <a class="dropdown-item {{ Request::is('practice-area-guides') ? 'active' : '' }}" href="{{ url('/practice-area-guides') }}">
                                                        Practice area guides
                                                    </a>
                                                </li>
                                                <li class="d-mob-show">
                                                    <a class="dropdown-item {{ Request::is('interview-guides') ? 'active' : '' }}" href="{{ url('/interview-guides') }}"> 
                                                        Interview guides
                                                    </a>
                                                </li>
                                                <li class="dropdown-submenu list-style d-des-menu">
                                                    <a class="dropdown-item dropdown-toggle {{ (Request::is('practice-area-sections') || Request::is('interview-guide-sections')) ? 'active' : 'text-muted' }}">Sections</a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li>
                                                            <a class="dropdown-item {{ Request::is('practice-area-sections') ? 'text-blue' : 'text-muted' }}" href="{{ url('/practice-area-sections') }}">
                                                                Practice area sections
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item {{ Request::is('interview-guide-sections') ? 'text-blue' : 'text-muted' }}" href="{{ url('/interview-guide-sections') }}"> 
                                                                Interview sections
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu list-style d-des-menu">
                                                    <a class="dropdown-item dropdown-toggle {{ (Request::is('practice-area-guides') || Request::is('interview-guides')) ? 'active' : 'text-muted' }}">Guides</a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li>
                                                            <a class="dropdown-item {{ Request::is('practice-area-guides') ? 'text-blue' : 'text-muted' }}" href="{{ url('/practice-area-guides') }}">
                                                                Practice area guides
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item {{ Request::is('interview-guides') ? 'text-blue' : 'text-muted' }}" href="{{ url('/interview-guides') }}"> 
                                                                Interview guides
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="list-style">
                                                    <a class="dropdown-item text-muted {{ Request::is('survey') ? 'active' : '' }}" href="{{ url('/survey') }}">
                                                        Survey
                                                    </a>
                                                </li>
                                                <li class="list-style">
                                                    <a class="dropdown-item text-muted {{ Request::is('useful-links') ? 'active' : '' }}" href="{{ url('/useful-links') }}">
                                                        Useful links
                                                    </a>
                                                </li>
                                                <li class="list-style">
                                                    <a class="dropdown-item text-muted {{ Request::is('helpful-articles') ? 'active' : '' }}" href="{{ url('/helpful-articles') }}">
                                                        Helpful articles
                                                    </a>
                                                </li>
                                                <li class="list-style">
                                                    <a class="dropdown-item text-muted {{ Request::is('feedbacks') ? 'active' : '' }}" href="{{ url('/feedbacks') }}">
                                                        Feedback
                                                    </a>
                                                </li>
                                                <li class="list-style">
                                                    <a class="dropdown-item text-muted {{ Request::is('reports') ? 'active' : '' }}" href="{{ url('/reports') }}">
                                                        Reports 
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4 border-right">                                           
                                            <a class="dropdown-item text-muted {{ Request::is('upload-file') ? 'active' : '' }}" href="{{ url('/upload-file') }}">
                                            Upload File 
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('region') ? 'active' : '' }}" href="{{ url('/region') }}">
                                            Region
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('location') ? 'active' : '' }}" href="{{ url('/location') }}">
                                            Location
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('hire-location') ? 'active' : '' }}" href="{{ url('/hire-location') }}">
                                            Hire Location
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('service') ? 'active' : '' }}" href="{{ url('/service') }}">
                                            Service
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('recruitment-type') ? 'active' : '' }}" href="{{ url('/recruitment-type') }}">
                                            Recruitment type
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('practice-area') ? 'active' : '' }}" href="{{ url('/practice-area') }}">
                                            Practice Area
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('sector') ? 'active' : '' }}" href="{{ url('/sector') }}">
                                            Sector
                                            </a>
                                        </div>
                                        <div class="col-md-4 pr-4">
                                            <a class="dropdown-item text-muted {{ Request::is('recruitment-firm') ? 'active' : '' }}" href="{{ url('/recruitment-firm') }}">
                                            Recruitment Firm
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('firm-location') ? 'active' : '' }}" href="{{ url('/firm-location') }}">
                                            Firm Location
                                            </a>
                                            <!-- <a class="dropdown-item text-muted {{ Request::is('firm-hire-location') ? 'active' : '' }}" href="{{ url('/firm-hire-location') }}">
                                            Firm Hire Location
                                            </a> -->
                                            <a class="dropdown-item text-muted {{ Request::is('firm-service') ? 'active' : '' }}" href="{{ url('/firm-service') }}">
                                            Firm Service
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('firm-recruitment-type') ? 'active' : '' }}" href="{{ url('/firm-recruitment-type') }}">
                                            Firm Recruitment Type
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('firm-client') ? 'active' : '' }}" href="{{ url('/firm-client') }}">
                                            Firm Client
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('firm-practice-area') ? 'active' : '' }}" href="{{ url('/firm-practice-area') }}">
                                            Firm Practice Area
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('firm-sector') ? 'active' : '' }}" href="{{ url('/firm-sector') }}">
                                            Firm Sector
                                            </a>
                                            <a class="dropdown-item text-muted {{ Request::is('firm-recruitment-region') ? 'active' : '' }}" href="{{ url('/firm-recruitment-region') }}">
                                            Firm Region
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="style-dashed">
                                    <div class="row py-2 w-640">
                                        <div class="col-md-4 border-right pl-4">
                                            <a class="dropdown-item text-muted {{ Request::is('click-analytics') ? 'active' : '' }}" href="{{ url('/click-analytics') }}">
                                            Click Analytics
                                            </a>
                                        </div>
                                        <div class="col-md-4 border-right">
                                            <a class="dropdown-item text-muted {{ Request::is('login-count') ? 'active' : '' }}" href="{{ url('/login-count') }}">
                                            Login Count 
                                            </a>
                                        </div>
                                    </div>
                                    @else
                                    <a class="dropdown-item text-muted" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    @endif
                                </div>
                            </li>
                        @else 
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @endif                        
                        <!-- @if(Auth::user() && (Auth::user()->is_active == "Yes"))
                            
                        @endif -->
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <div class="container-fluid">
               {{-- @if (Auth::user()->is_active == "YES") --}} 
                <nav class="sidebar pt-3 pb-2 collapse navbar-collapse" id="sidebar" ng-controller="SearchDataController">
                    <button type="button" class="close" data-toggle="collapse" data-target="#sidebar" aria-expanded="false" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        <span class="close"></span>
                    </button>
                    <form action="{{ url('/search-recruitment-firm') }}" method="POST" id="searchFirm">
                        @csrf
                    <div class="recruitment">
                        <p for="recruitmentFirm" class="text-dark mt-1 mb-2">Search recruiter</p>
                        <select ng-model="search_data.firm_id" name="firm_id"
                                ng-options="firm as firm.name for firm in search_firms track by firm.id">
                                <option value="">Any</option>
                        </select>
                    </div>
                    <div class="find-recruiters">
                        <p class="text-dark mb-1">Suggest a recruiter</p>
                        <label for="location">I am looking for a recruiter in…</label>
                        <select  class="mb8" name="search_locations" 
                                ng-model="search_data.search_location"
                                ng-options="loc as loc.name group by loc.region.name for loc in search_locations 
                                | orderBy:['loc.name','region.ordering'] track by loc.id">
                                <option value="">Any</option>
                        </select>

                        <!--
                        <label for="location_role">Location of hire</label>
                        <select class="mb8" name="hire_locations" 
                                ng-model="search_data.hire_location"
                                ng-options="loc as loc.name group by loc.region.name for loc in hire_locations  | orderBy:['loc.name','region.ordering'] track by loc.id" >
                                <option value="">Any</option>
                        </select> -->
                        <label for="service">I am currently a…</label>
                        <select class="mb8" name="service_id" 
                                ng-model="search_data.service_id" 
                                ng-options="service as service.name for service in search_services track by service.id">
                                <option value="">Any</option>
                        </select>
                        <label for="roleType">I am looking for a role in…</label>
                        <select class="mb8" name="recruitment_id" 
                                ng-model="search_data.recruitment_id" 
                                ng-options="rt as rt.name for rt in search_roletypes track by rt.id">
                                <option value="">Any</option>
                        </select>
                        <label for="practiceArea">My main practice area is….</label>
                        <select class="mb8" name="practice_area_id"
                                ng-model="search_data.practice_area_id" 
                                ng-options="area as area.name group by area.type for area in search_areas  | filter: { type: '!GENERAL' } track by area.id">
                                <option value="">General</option>
                        </select>
                        <!--
                        <label for="recruitmentSize">I would prefer the recruitment firm to be…</label>
                        <select class="mb8" ng-model="size" name="size" id="size">
                            <option value="">Any</option>
                            <option value="<?php echo \App\RecruitmentFirm::SIZE_SMALL; ?>"><?php echo \App\RecruitmentFirm::SIZE_SMALL_TEXT; ?></option>
                            <option value="<?php echo \App\RecruitmentFirm::SIZE_MEDIUM; ?>"><?php echo \App\RecruitmentFirm::SIZE_MEDIUM_TEXT; ?></option>
                            <option value="<?php echo \App\RecruitmentFirm::SIZE_LARGE; ?>"><?php echo \App\RecruitmentFirm::SIZE_LARGE_TEXT; ?></option>
                        </select> -->
                        <!--
                        <label for="sector">Sector</label>
                        <select class="mb8" name="sector_id" 
                                ng-model="search_data.sector_id" 
                                ng-options="sector as sector.name group by sector.type for sector in search_sectors  | filter: { type: '!GENERAL' } track by sector.id">
                                <option value="">General</option>
                        </select> -->
                        <button type="submit" class="btn btn-sm btn-form br-40 w-100 mb-2">Search</button>
                        <button type="button" ng-click="clearSearch()" class="btn btn-sm bg-blue br-40 w-100">Clear Search</button>
                        </form>
                    </div>
                    <div class="row footer">
                        <div class="col-md-12 padding-0 pt-0">
                            <small>
                                <a href="/terms" class="text-signIn">Terms &amp; Conditions</a> <span class="text-signIn"> | </span> 
                                <a href="/privacy" class="text-signIn">Privacy Policy</a>
                            </small>
                        </div>
                        <div class="col-md-12 padding-0 pt-0">
                            <small style="font-size:70% !important">Copyright 2021 The Rackle All rights reserved.</small>
                        </div>
                    </div>
                </nav>
                

                {{-- @endif --}}
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    <div raw-ajax-busy-indicator class="bg_load dis-flex justify-content-center align-items-center" style="display: none !important;">
        <!-- <img src="/img/loader.gif" style="top: 44%;margin-left: 44%;"> -->
        <div id="loader"></div>
    </div>
    <div id="cookie_show" class="cookie-container display-none">
        <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0 pr-14">This website uses cookies to ensure you get the best experience on our website. <a href="/cookies">Read More</a></p>
            <div class="float-right">
                <button class="submit btn btn-form br-40 px-4" onclick="acceptCookies()">Got it</button>
            </div>
        </div>
    </div>
    @if (session('firm_id'))
    <input type="text" style="display:none;" name="firm" id="firm" value="{{ session('firm_id') }}"><br>
    @endif
    @if (session('location_id'))
    <input type="text" style="display:none;" name="location" id="location" value="{{ session('location_id') }}"><br>
    @endif
    @if (session('hire_loc_id'))
    <input type="text" style="display:none;" name="hire_location" id="hire_location" value="{{ session('hire_loc_id') }}"><br>
    @endif
    @if (session('service_id'))
    <input type="text" style="display:none;" name="service" id="service" value="{{ session('service_id') }}"><br>
    @endif
    @if (session('recruitment_id'))
    <input type="text" style="display:none;" name="recruitment" id="recruitment" value="{{ session('recruitment_id') }}"><br>
    @endif
    @if (session('firm_size'))
    <input type="text" style="display:none;" name="firm_size" id="firm_size" value="{{ session('firm_size') }}"><br>
    @endif
    @if (session('practice_area_id'))
    <input type="text" style="display:none;" name="practice_area" id="practice_area" value="{{ session('practice_area_id') }}"><br>
    @endif
    @if (session('sector_id'))
    <input type="text" style="display:none;" name="sector" id="sector" value="{{ session('sector_id') }}"><br>
    @endif
</body>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#size').val($('#firm_size').val());
        $(document).ajaxStop(function () {
            $('.bg_load').hide();
        });

        $(document).ajaxStart(function () {
            $('.bg_load').show();
        });

        $('.capture-ext-links').on('click', 'a', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');
            if(link){
                if(link.startsWith("http")){
                    $.ajax({
                        url: '/click-analytics/capture-external-links',
                        method: "POST",
                        data : {
                            href: link,
                            "_token": "{{ csrf_token() }}",
                        },
                        success :  function(data){
                            window.open(link, "_blank");
                        }
                    })
                } 
            }                       
        });
        
    });

    /* Cookies Functionality */
    if(Cookies.get('Rackle')) {
        $('#cookie_show').css('display', 'none');
    } else {
        $('#cookie_show').css('display', 'block');
    }

    function acceptCookies() {
        var date = new Date();
        date.setTime(date.getTime() + (1200 * 1000));
        Cookies.set('Rackle', true, { expires: date });
        $('#cookie_show').css('display', 'none');
    }
</script>

</html>