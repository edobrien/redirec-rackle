<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('practice-guide-details', function () {
    return view('practice-area-guide.practice-guide-details');
});


// Route::get('interview-guides-details', function () {
//     return view('interview-guides.interview-guides-details');
// });


Route::get('terms', function () {
    return view('terms-privacy.terms');
});
Route::get('privacy', function () {
    return view('terms-privacy.privacy');
});
Route::get('access-denied', function () {
    return view('access-denied.404-access-denied');
});
Route::get('search-results', function () {
    return view('search-results');
});
Route::get('upload-file', function () {
    return view('upload-file');
});


Auth::routes();
Route::post('/login' , 'Auth\AuthController@authenticate');
Route::middleware(['auth'])->group(function () {

    Route::get('/approval', 'HomeController@approval')->name('approval');

    //Search page data
    Route::get('/recruitment-firm/get-active-firms', 'Admin\Firm\RecruitmentFirmController@getActiveFirms');
    Route::get('/location/get-active-locations', 'Admin\LocationController@getActiveLocations');
    Route::get('/service/get-active-services', 'Admin\ServiceController@getActiveServices');
    Route::get('/recruitment-type/get-active-types', 'Admin\RecruitmentTypeController@getActiveRecruitmentTypes');
    Route::get('/practice-area/get-active-areas', 'Admin\PracticeAreaController@getActivePracticeAreas');
    Route::get('/sector/get-active-sectors', 'Admin\SectorController@getActiveSectors');

    //Listing management data
    Route::get('/practice-area-guides/get-active-guides', 'Admin\PracticeAreaGuideController@getActiveGuides');
    Route::get('/interview-guides/get-active-guides', 'Admin\InterviewGuideController@getActiveGuides');
    Route::get('/survey/get-active-surveys', 'Admin\SurveyController@getActiveSurveys');
    Route::get('/useful-links/get-active-links', 'Admin\UsefulLinksController@getActiveUsefulLinks');
    Route::get('/helpful-articles/get-active-articles', 'Admin\HelpfulArticleController@getActiveArticles');
    Route::get('/reports/get-active-reports', 'Admin\ReportController@getActiveReports');

    //Feedback
    Route::post('/feedback/save-form', 'FeedbackController@saveForm');

    //Register newsletter
    Route::post('/user/newsletter-register', 'FeedbackController@registerNewsletter');

    //Practice Area Guides listing
    Route::get('practice-area-guide', 'Admin\PracticeAreaGuideController@getActivePracticeGuides');
    Route::post('practice-area-guide-detail', 'Admin\PracticeAreaGuideController@saveViewCount');
    Route::get('practice-area-guide-detail/{id}', 'Admin\PracticeAreaGuideController@getGuideView');

    //Interview Guide listing
    Route::get('interview-guide', 'Admin\InterviewGuideController@getActiveInterviewGuides');
    Route::post('interview-guide-detail', 'Admin\InterviewGuideController@saveViewCount');
    Route::get('interview-guide-detail/{id}', 'Admin\InterviewGuideController@getGuideView');

    //Report Listing
    Route::get('reports-analysis', 'Admin\ReportController@getActiveReportListing');
    Route::post('reports-analysis/send-report-email', 'Admin\ReportController@notifyReportRequest');

    //Useful link listing
    Route::get('useful-link', 'Admin\UsefulLinksController@getActiveUsefulLinksListing');

    //Useful link listing
    Route::get('helpful-article', 'Admin\HelpfulArticleController@getActiveArticleListing');

    Route::get('feedback-surveys', function () {
        return view('feedback-surveys');
    });

    //Search recruitment firm
    Route::post('/search-recruitment-firm', 'RecruitmentSearchController@searchFirm');
    Route::get('/search-recruitment-firm', 'RecruitmentSearchController@searchFirm');
    Route::get('/firm-view-count/{id}', 'RecruitmentSearchController@saveViewCount');

    Route::get('/search-recruitment-firm', function () {
        return view('search-restriction');
    });

    Route::middleware(['approved'])->group(function() {
        Route::get('/home', 'HomeController@index')->name('home');
    });

    Route::middleware(['admin'])->group(function() {

        //Users 
        Route::get('/users', 'UserController@index');
        Route::get('/users/{user_id}/approve', 'UserController@approve');
        Route::get('user', 'UserController@index');
        Route::get('user/list-users/{status?}', 'UserController@listUsers');
        Route::get('user/get-info/{id}', 'UserController@getInfo');
        Route::post('user/update', 'UserController@updateUser');
        Route::get('user/delete/{id}', 'UserController@delete');

        //Practice area guides
        Route::get('/practice-area-guides', 'Admin\PracticeAreaGuideController@index');
        Route::get('/practice-area-guides/list-guides', 'Admin\PracticeAreaGuideController@listGuides');
        Route::post('/practice-area-guides/add-update-guides', 'Admin\PracticeAreaGuideController@addOrUpdate');
        Route::get('/practice-area-guides/get-info/{id}', 'Admin\PracticeAreaGuideController@getInfo');
        Route::get('/practice-area-guides/delete/{id}', 'Admin\PracticeAreaGuideController@delete');

        //Interview guides
        Route::get('/interview-guides', 'Admin\InterviewGuideController@index');
        Route::get('/interview-guides/list-guides', 'Admin\InterviewGuideController@listGuides');
        Route::post('/interview-guides/add-update-guides', 'Admin\InterviewGuideController@addOrUpdate');
        Route::get('/interview-guides/get-info/{id}', 'Admin\InterviewGuideController@getInfo');
        Route::get('/interview-guides/delete/{id}', 'Admin\InterviewGuideController@delete');

        //Survey
        Route::get('/survey', 'Admin\SurveyController@index');
        Route::get('/survey/list-url', 'Admin\SurveyController@listSurvies');
        Route::post('/survey/add-update-url', 'Admin\SurveyController@addOrUpdate');
        Route::get('/survey/get-info/{id}', 'Admin\SurveyController@getInfo');
        Route::get('/survey/delete/{id}', 'Admin\SurveyController@delete');

        //Useful Links
        Route::get('/useful-links', 'Admin\UsefulLinksController@index');
        Route::get('/useful-links/list-url', 'Admin\UsefulLinksController@listLinks');
        Route::post('/useful-links/add-update-url', 'Admin\UsefulLinksController@addOrUpdate');
        Route::get('/useful-links/get-info/{id}', 'Admin\UsefulLinksController@getInfo');
        Route::get('/useful-links/delete/{id}', 'Admin\UsefulLinksController@delete');

        //Helpful Articles
        Route::get('/helpful-articles', 'Admin\HelpfulArticleController@index');
        Route::get('/helpful-articles/list-article', 'Admin\HelpfulArticleController@listArticles');
        Route::post('/helpful-articles/add-update-article', 'Admin\HelpfulArticleController@addOrUpdate');
        Route::get('/helpful-articles/get-info/{id}', 'Admin\HelpfulArticleController@getInfo');
        Route::get('/helpful-articles/delete/{id}', 'Admin\HelpfulArticleController@delete');

        //Reports
        Route::get('/reports', 'Admin\ReportController@index');
        Route::get('/reports/list-report', 'Admin\ReportController@listReports');
        Route::post('/reports/add-update-report', 'Admin\ReportController@addOrUpdate');
        Route::get('/reports/get-info/{id}', 'Admin\ReportController@getInfo');
        Route::get('/reports/delete/{id}', 'Admin\ReportController@delete');

        //Feedback view        
        Route::get('/feedbacks', 'FeedbackController@index');
        Route::get('/feedbacks/list-feedback', 'FeedbackController@listFeedbacks');
        Route::get('/feedbacks/get-feedback/{id}', 'FeedbackController@getInfo');

        //Recruitment firm management screen
        //Regions
        Route::get('/region', 'Admin\RegionController@index');
        Route::get('/region/list-regions', 'Admin\RegionController@listRegions');
        Route::post('/region/add-update-region', 'Admin\RegionController@addOrUpdate');
        Route::get('/region/get-info/{id}', 'Admin\RegionController@getInfo');
        Route::get('/region/can-delete-region/{id}', 'Admin\RegionController@canDeleteRegion');
        Route::get('/region/delete/{id}', 'Admin\RegionController@delete');
        Route::get('/region/get-active-region', 'Admin\RegionController@getActiveRegions');

        //Locations
        Route::get('/location', 'Admin\LocationController@index');
        Route::get('/location/list-locations', 'Admin\LocationController@listLocations');
        Route::post('/location/add-update-location', 'Admin\LocationController@addOrUpdate');
        Route::get('/location/get-info/{id}', 'Admin\LocationController@getInfo');
        Route::get('/location/can-delete-location/{id}', 'Admin\LocationController@canDeleteLocation');
        Route::get('/location/delete/{id}', 'Admin\LocationController@delete');

        //Service
        Route::get('/service', 'Admin\ServiceController@index');
        Route::get('/service/list-services', 'Admin\ServiceController@listServices');
        Route::post('/service/add-update-service', 'Admin\ServiceController@addOrUpdate');
        Route::get('/service/get-info/{id}', 'Admin\ServiceController@getInfo');
        Route::get('/service/can-delete-service/{id}', 'Admin\ServiceController@canDeleteService');
        Route::get('/service/delete/{id}', 'Admin\ServiceController@delete');

        //Recruitment Type
        Route::get('/recruitment-type', 'Admin\RecruitmentTypeController@index');
        Route::get('/recruitment-type/list-types', 'Admin\RecruitmentTypeController@listTypes');
        Route::post('/recruitment-type/add-update-type', 'Admin\RecruitmentTypeController@addOrUpdate');
        Route::get('/recruitment-type/get-info/{id}', 'Admin\RecruitmentTypeController@getInfo');
        Route::get('/recruitment-type/can-delete-type/{id}', 'Admin\RecruitmentTypeController@canDeleteRecruitment');
        Route::get('/recruitment-type/delete/{id}', 'Admin\RecruitmentTypeController@delete');
        

        //Practice Area
        Route::get('/practice-area', 'Admin\PracticeAreaController@index');
        Route::get('/practice-area/list-areas', 'Admin\PracticeAreaController@listPracticeAreas');
        Route::post('/practice-area/add-update-area', 'Admin\PracticeAreaController@addOrUpdate');
        Route::get('/practice-area/get-info/{id}', 'Admin\PracticeAreaController@getInfo');
        Route::get('/practice-area/can-delete-area/{id}', 'Admin\PracticeAreaController@canDeleteArea');
        Route::get('/practice-area/delete/{id}', 'Admin\PracticeAreaController@delete');

        //File Downloads
        Route::get('/data-upload', 'Admin\DataUploadController@index');        
        Route::get('/data-upload/list', 'Admin\DataUploadController@listDataUploads');
        Route::get('/data-upload/download/{file_id}', 'Admin\DataUploadController@downloadFile');


        //Sectors
        Route::get('/sector', 'Admin\SectorController@index');
        Route::get('/sector/list-sectors', 'Admin\SectorController@listSectors');
        Route::post('/sector/add-update-sector', 'Admin\SectorController@addOrUpdate');
        Route::get('/sector/get-info/{id}', 'Admin\SectorController@getInfo');
        Route::get('/sector/can-delete-sector/{id}', 'Admin\SectorController@canDeleteSector');
        Route::get('/sector/delete/{id}', 'Admin\SectorController@delete');

        //Recruitment Firm
        Route::get('/recruitment-firm', 'Admin\Firm\RecruitmentFirmController@index');
        Route::get('/recruitment-firm/list-firm', 'Admin\Firm\RecruitmentFirmController@listFirms');
        Route::post('/recruitment-firm/add-update-firm', 'Admin\Firm\RecruitmentFirmController@addOrUpdate');
        Route::get('/recruitment-firm/get-info/{id}', 'Admin\Firm\RecruitmentFirmController@getInfo');
        Route::get('/recruitment-firm/can-delete-firm/{id}', 'Admin\Firm\RecruitmentFirmController@canDeleteFirm');
        Route::get('/recruitment-firm/delete/{id}', 'Admin\Firm\RecruitmentFirmController@delete');
        Route::get('/recruitment-firm/delete-logo/{id}', 'Admin\Firm\RecruitmentFirmController@deleteLogo');
        
        //Recruitment firm pivot tables
        //Firm location mapping
        Route::get('/firm-location', 'Admin\Firm\FirmLocationController@index');
        Route::get('/firm-location/list-firm-locations', 'Admin\Firm\FirmLocationController@listFirmlocations');
        Route::post('/firm-location/add-update-firm-location', 'Admin\Firm\FirmLocationController@addOrUpdate');
        Route::get('/firm-location/get-info/{id}', 'Admin\Firm\FirmLocationController@getInfo');
        Route::get('/firm-locations/delete/{id}', 'Admin\Firm\FirmLocationController@delete');

        //Firm service mapping
        Route::get('/firm-service', 'Admin\Firm\FirmServiceController@index');
        Route::get('/firm-service/list-firm-services', 'Admin\Firm\FirmServiceController@listFirmServices');
        Route::post('/firm-service/add-update-firm-service', 'Admin\Firm\FirmServiceController@addOrUpdate');
        Route::get('/firm-service/get-info/{id}', 'Admin\Firm\FirmServiceController@getInfo');
        Route::get('/firm-service/delete/{id}', 'Admin\Firm\FirmServiceController@delete');

        //Firm role type mapping
        Route::get('/firm-recruitment-type', 'Admin\Firm\FirmRecruitmentTypeController@index');
        Route::get('/firm-recruitment-type/list-firm-types', 'Admin\Firm\FirmRecruitmentTypeController@listFirmRecruitmentTypes');
        Route::post('/firm-recruitment-type/add-update-type', 'Admin\Firm\FirmRecruitmentTypeController@addOrUpdate');
        Route::get('/firm-recruitment-type/get-info/{id}', 'Admin\Firm\FirmRecruitmentTypeController@getInfo');
        Route::get('/firm-recruitment-type/delete/{id}', 'Admin\Firm\FirmRecruitmentTypeController@delete');

        //Firm practice area mapping
        Route::get('/firm-practice-area', 'Admin\Firm\FirmPracticeAreaController@index');
        Route::get('/firm-practice-area/list-firm-areas', 'Admin\Firm\FirmPracticeAreaController@listFirmPracticeAreas');
        Route::post('/firm-practice-area/add-update-area', 'Admin\Firm\FirmPracticeAreaController@addOrUpdate');
        Route::get('/firm-practice-area/get-info/{id}', 'Admin\Firm\FirmPracticeAreaController@getInfo');
        Route::get('/firm-practice-area/delete/{id}', 'Admin\Firm\FirmPracticeAreaController@delete');

        //Firm sector mapping
        Route::get('/firm-sector', 'Admin\Firm\FirmSectorController@index');
        Route::get('/firm-sector/list-firm-sectors', 'Admin\Firm\FirmSectorController@listFirmSectors');
        Route::post('/firm-sector/add-update-sector', 'Admin\Firm\FirmSectorController@addOrUpdate');
        Route::get('/firm-sector/get-info/{id}', 'Admin\Firm\FirmSectorController@getInfo');
        Route::get('/firm-sector/delete/{id}', 'Admin\Firm\FirmSectorController@delete');

        //Firm recruitment firm mapping
        Route::get('/firm-recruitment-region', 'Admin\Firm\FirmRecruitmentRegionController@index');
        Route::get('/firm-recruitment-region/list-firm-regions', 'Admin\Firm\FirmRecruitmentRegionController@listFirmRegions');
        Route::post('/firm-recruitment-region/add-update-region', 'Admin\Firm\FirmRecruitmentRegionController@addOrUpdate');
        Route::get('/firm-recruitment-region/get-info/{id}', 'Admin\Firm\FirmRecruitmentRegionController@getInfo');
        Route::get('/firm-recruitment-region/delete/{id}', 'Admin\Firm\FirmRecruitmentRegionController@delete');

        //Firm recruitment firm mapping
        Route::get('/firm-client', 'Admin\Firm\FirmClientController@index');
        Route::get('/firm-client/list-firm-clients', 'Admin\Firm\FirmClientController@listFirmClients');
        Route::post('/firm-client/add-update-client', 'Admin\Firm\FirmClientController@addOrUpdate');
        Route::get('/firm-client/get-info/{id}', 'Admin\Firm\FirmClientController@getInfo');
        Route::get('/firm-client/delete/{id}', 'Admin\Firm\FirmClientController@delete');

        //Import and Export data
        Route::get('/download-template', 'FirmDataLoadController@downloadTemplate');
        Route::post('/upload-firms', 'FirmDataLoadController@uploadData');
        Route::get('/read-uploaded-file', 'FirmDataLoadController@importTemplate');

        //Analytics - Capture external links in pages - Surveys, Recruitment listing page
        //Practice area and interview guide details, useful links and blog articles
        Route::get('/click-analytics', 'AnalyticsController@index');
        Route::get('/click-analytics/list-clicks', 'AnalyticsController@listCaptureClicks');
        Route::post('/click-analytics/capture-external-links', 'AnalyticsController@captureClicks');
        Route::get('/click-analytics/download-report', 'AnalyticsController@downloadClickReport');

        //Analytics - Registered user login count
        Route::get('/login-count', 'AnalyticsController@indexLoginCount');
        Route::get('/login-count/list-user-count', 'AnalyticsController@listUserLogins');
    });
    
});
