var app = angular.module('MyFlickrApp', ['ngMaterial'], function($interpolateProvider,$httpProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8;';

});



app.controller('MyFlickerController', function ($http,$scope, $mdDialog, ImageInfoService ) {

    $scope.showEdit = function(event,photo_id) {

        ImageInfoService.getData(photo_id).then(function (result) {

            $mdDialog.show({
                templateUrl: 'html_template/flickr/dialog_edit_content.html',
                locals: {
                    result:  result
                },
                fullscreen: $scope.customFullscreen,
                parent: angular.element(document.body),
                controller: DialogCtrl,
                targetEvent: event,
            })

        });

        function DialogCtrl($scope,$mdDialog,result,$window) {
            $scope.photo_info = result.data.photo;

            $scope.setImageInfo = function($event) {
                ImageInfoService.setImageInfo($scope.photo_info).then(function (result) {

                    if(result.data.need_redirect){
                        $window.location.href = result.data.url;
                    }

                    if(result.data.ok){
                        $mdDialog.show(
                            $mdDialog.alert()
                                .parent(angular.element(document.querySelector('#popupContainer')))
                                .clickOutsideToClose(true)
                                .textContent('Seved')
                                .ok('Got it!')
                                .targetEvent(event)


                        );
                    }

                });
            };

            $scope.answer = function(answer) {
                $mdDialog.hide(answer);
            };
        }
    };
});

app.factory('ImageInfoService', function ($http) {

    var getData = function (photo_id) {
        var data = $.param({
            photo_id: photo_id,
        });

        return $http.post('/show_flicker_image_info', data);
    };
    var setImageInfo = function(photo_info){
        var data = $.param({
            photo_info: photo_info,
        });

        return $http.post('/set_flicker_image_info', data);
    }
    return {
        getData: getData,
        setImageInfo: setImageInfo,
    };
});