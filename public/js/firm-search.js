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
                    selected = $('#firm').val();
                    if(selected){
                        index = $scope.getSelectedItem($scope.search_firms, 
                                                        selected);
                        $scope.search_data.firm_id = $scope.search_firms[index];
                    }
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
                    selected = $('#location').val();
                    if(selected){
                        index = $scope.getSelectedItem($scope.search_locations, 
                                                        selected);
                        $scope.search_data.location_id = $scope.search_locations[index];
                    }
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
                    selected = $('#service').val();
                    if(selected){
                        index = $scope.getSelectedItem($scope.search_services, 
                                                        selected);
                        $scope.search_data.service_id = $scope.search_services[index];
                    }
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
                    selected = $('#recruitment').val();
                    if(selected){
                        index = $scope.getSelectedItem($scope.search_roletypes, 
                                                        selected);
                        $scope.search_data.recruitment_id = $scope.search_roletypes[index];
                    }
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
                    selected = $('#practice_area').val();
                    if(selected){
                        index = $scope.getSelectedItem($scope.search_areas, 
                                                        selected);
                        $scope.search_data.practice_area_id = $scope.search_areas[index];
                    }
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
                    selected = $('#sector').val();
                    if(selected){
                        index = $scope.getSelectedItem($scope.search_sectors, 
                                                        selected);
                        $scope.search_data.sector_id = $scope.search_sectors[index];
                    }
                } else {
                    alert("Error in fetching active practice areas");
                }
            }).finally(function(){
                $(".bg_load").hide();
            });
        }

        $scope.getSelectedItem = function(myArray, selectedValue){
            count = 0;
            for(let i = 0; i < myArray.length; i++){
                count += 1;
                if(myArray[i].id == selectedValue){
                    return (count-1);
                }
            }
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
        }
        $scope.init();
    });