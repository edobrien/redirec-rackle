    var app = angular.module('recdirecApp', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

    app.controller('SearchDataController', function ($scope, $http, $compile) {

        $scope.getActiveFirms = function(){
            $(".bg_load").show();
            $scope.search_firms = {};
            var url = 'recruitment-firm/get-active-firms';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.search_firms = response.data.firms;                    
                } else {
                    alert("Error in fetching active firms");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.getActiveLocations = function(){
            $(".bg_load").show();
            $scope.search_locations = {};
            var url = 'location/get-active-locations';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.search_locations = response.data.locations;
                } else {
                    alert("Error in fetching active locations");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.getActiveServices = function(){
            $(".bg_load").show();
            $scope.search_services = {};
            var url = '/service/get-active-services';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.search_services = response.data.services;
                } else {
                    alert("Error in fetching active services");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.getActiveRoleTypes = function(){
            $(".bg_load").show();
            $scope.search_roletypes = {};
            var url = '/recruitment-type/get-active-types';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.search_roletypes = response.data.types;
                } else {
                    alert("Error in fetching active role types");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.getActivePracticeAreas = function(){
            $(".bg_load").show();
            $scope.search_roletypes = {};
            var url = '/practice-area/get-active-areas';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.search_areas = response.data.areas;
                } else {
                    alert("Error in fetching active practice areas");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.getActiveSectors = function(){
            $(".bg_load").show();
            $scope.search_roletypes = {};
            var url = '/sector/get-active-sectors';
            $http.get(url).then(function (response) {
                if (response.data.status == 'SUCCESS') {
                    $scope.search_sectors = response.data.sectors;
                } else {
                    alert("Error in fetching active practice areas");
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
        }

        $scope.init = function () {
            $scope.search_data = {};
            $scope.errors = $scope.successMessage = $scope.modalErrors = null;
            $scope.getActiveFirms();
            $scope.getActiveLocations();
            $scope.getActiveServices();
            $scope.getActiveRoleTypes();
            $scope.getActivePracticeAreas();
            $scope.getActiveSectors();

            $('#recruitmentFirm').val(parseInt($('#firm').val()));
        }
        $scope.init();
    });