<!DOCTYPE html>
<html ng-app="app" ng-controller="AppCtrl">
    <head>
        <title>Angular PDF.js demo</title>
        <script src="js/pdf.js"></script>
        <link rel="stylesheet" href="css/viewer.css">

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <script src="js/dist/angular-pdfjs-viewer.js"></script>
        <script src="js/pdf_app.js"></script>
        <script src="js/pdf.worker.js"></script>

        <style>
          html, body { height: 100%; width: 100%; margin: 0; padding: 0; }
          .some-pdf-container { width: 100%; height: 100%; }
        </style>
    </head>
    <body>
        <div class="some-pdf-container">
            <pdfjs-viewer src="http://dev.recdirec.com:8001/asset/report-docs/1580390701.pdf"></pdfjs-viewer>
        </div>
    </body>
</html>