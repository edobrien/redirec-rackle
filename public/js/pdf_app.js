angular.module('app', ['pdfjsViewer']);

angular.module('app').controller('AppCtrl', function ($scope, $http, $timeout) {

    $scope.init = function(){
        $scope.pdf = {
            src: 'http://www.africau.edu/images/default/sample.pdf',  // get pdf source from a URL that points to a pdf
            data: null // get pdf source from raw data of a pdf
        };
    }   

    // getPdfAsArrayBuffer(url).then(function (response) {
    //     $scope.pdf.data = new Uint8Array(response.data);
    // }, function (err) {
    //     console.log('failed to get pdf as binary:', err);
    // });

    // function getPdfAsArrayBuffer (url) {
    //     return $http.get(url, {
    //         responseType: 'arraybuffer',
    //         headers: {
    //             'foo': 'bar'
    //         }
    //     });
    // }
});
