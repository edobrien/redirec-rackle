<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"content="width=device-width, initial-scale=1">
     
    <!-- CSRF Token -->
    <meta name="csrf-token"content="{{ csrf_token() }}">
    <link rel="icon"href="../img/fav.png">
    <title>Recdirec</title>

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
                    <!-- {{ config('app.name', 'Laravel') }} -->
                    <img src="../img/logo-header.png" alt="Recdirec">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        @if (Auth::user()->is_active == "YES")
                            <li class="nav-item {{ Request::is('practice-area-guide') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/practice-area-guide') }}">Practice Areas</a>
                            </li>
                            <li class="nav-item {{ Request::is('useful-links') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/useful-link') }}">Jobs</a>
                            </li>
                            <li class="nav-item {{ Request::is('interview-guide') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/interview-guide') }}">Advice</a>
                            </li>
                            <li class="nav-item {{ Request::is('reports-analysis') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/reports-analysis') }}">Reports</a>
                            </li>
                            <li class="nav-item {{ Request::is('feedback-surveys') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/feedback-surveys') }}">Surveys</a>
                            </li>
                            <li class="nav-item {{ Request::is('useful-links') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/helpful-article') }}">Blog</a>
                            </li>
                        @endif
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <!-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a> -->

                                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="icon ion-md-more pt-1 text-grey" style = "padding: 6px;
                                    margin-top: -3px;"></i>
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
                                                <li class="dropdown-submenu list-style">
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
                                                <li class="dropdown-submenu list-style">
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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <button class="navbar-toggler sidebar-button" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
            <div class="container-fluid">
                @if (Auth::user()->is_active == "YES")
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
                        <select class="mb8" name="search_locations" 
                                ng-model="search_data.search_location"
                                ng-options="loc as loc.name group by loc.region.name for loc in search_locations  | orderBy:['loc.name','region.ordering']  track by loc.id ">
                                <option value="">Any</option>
                        </select>
                        <!--
                        <label for="location_role">Location of hire</label>
                        <select class="mb8" name="hire_locations" 
                                ng-model="search_data.hire_location"
                                ng-options="loc as loc.name group by loc.region.name for loc in hire_locations  | orderBy:['loc.name','region.ordering'] track by loc.id" >
                                <option value="">Any</option>
                        </select> -->
                        <label for="roleType">I am currently a…</label>
                        <select class="mb8" name="recruitment_id" 
                                ng-model="search_data.recruitment_id" 
                                ng-options="rt as rt.name for rt in search_roletypes track by rt.id">
                                <option value="">Any</option>
                        </select>
                        <label for="service">I am looking for a role in…</label>
                        <select class="mb8" name="service_id" 
                                ng-model="search_data.service_id" 
                                ng-options="service as service.name for service in search_services track by service.id">
                                <option value="">Any</option>
                        </select>
                        <label for="practiceArea">My main practice area is….</label>
                        <select class="mb8" name="practice_area_id"
                                ng-model="search_data.practice_area_id" 
                                ng-options="area as area.name group by area.type for area in search_areas  | filter: { type: '!GENERAL' } track by area.id">
                                <option value="">General</option>
                        </select>
                        <label for="recruitmentSize">I would prefer the recruitment firm to be…</label>
                        <select class="mb8" ng-model="size" name="size" id="size">
                            <option value="">Any</option>
                            <option value="<?php echo \App\RecruitmentFirm::SIZE_SMALL; ?>"><?php echo \App\RecruitmentFirm::SIZE_SMALL_TEXT; ?></option>
                            <option value="<?php echo \App\RecruitmentFirm::SIZE_MEDIUM; ?>"><?php echo \App\RecruitmentFirm::SIZE_MEDIUM_TEXT; ?></option>
                            <option value="<?php echo \App\RecruitmentFirm::SIZE_LARGE; ?>"><?php echo \App\RecruitmentFirm::SIZE_LARGE_TEXT; ?></option>
                        </select>
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
                </nav>
                @endif
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    <div raw-ajax-busy-indicator class="bg_load text-center" style="display: none !important;">
        <img src="/img/loader.gif" style="margin-top:25%;">
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

    


    
</script>
</html>
