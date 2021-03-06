var app = angular.module('todoApp_TOROLNI', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('TodoListController', function() {
    var todoList = this;
    todoList.todos = [
        {text:'learn AngularJS', done:true},
        {text:'build an AngularJS app', done:false}];

    todoList.addTodo = function() {
        todoList.todos.push({text:todoList.todoText, done:false});
        todoList.todoText = '';
    };

    todoList.remaining = function() {
        var count = 0;
        angular.forEach(todoList.todos, function(todo) {
            count += todo.done ? 0 : 1;
        });
        return count;
    };

    todoList.archive = function() {
        var oldTodos = todoList.todos;
        todoList.todos = [];
        angular.forEach(oldTodos, function(todo) {
            if (!todo.done) todoList.todos.push(todo);
        });
    };
});




app.controller('Hello', function($scope, $http) {
    var data = $.param({
        api_key : '57f694132e4714c29a64c9af890b124e',
        tags: 'animals',
    });
    var config = {
        headers : {
            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
        }
    }
    $http.post('https://api.flickr.com/services/rest/?method=flickr.photos.search', data, config)
        .then(function successCallback(response) {
            // this callback will be called asynchronously
            // when the response is available
        }, function errorCallback(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
});;var app = angular.module('FlickrApp', ['ngMaterial'], function($interpolateProvider,$httpProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8;';
});

app.constant('API_KEY', '57f694132e4714c29a64c9af890b124e');


app.factory('ImageListService', function ($http,$httpParamSerializer,API_KEY) {
    var search_arguments ={};

    var getData = function () {
        var json_data = {
            api_key : API_KEY,
            format:'json',
            nojsoncallback:'1',
        };

        var data = $.param(json_data)+'&' +$httpParamSerializer(this.search_arguments);


       return $http.post('https://api.flickr.com/services/rest/?method=flickr.photos.search', data);
    };

    var setSearchArguments = function(search_arguments){
        this.search_arguments = search_arguments;
    }

    return {
        getData: getData,
        setSearchArguments : setSearchArguments,
    };
});

app.factory('ImageInfoService', function ($http,API_KEY) {
    var search_arguments = [];

    var getData = function (photo_id) {

        var data = $.param({
            api_key : API_KEY,
            format:'json',
            nojsoncallback:'1',
            photo_id: photo_id,
        });

        return $http.post('https://api.flickr.com/services/rest/?method=flickr.photos.getInfo', data);
    };
    return {
        getData: getData,
    };
});


app.directive('flickrImages', function() {
    return {
        templateUrl: 'html_template/flickr/image_list.html'
    };
});

app.directive('listItems', function(){
    return {
        restrict: 'EA',
        scope: {
            source: '='
        },
        template: '<ul><li ng-repeat="item in data" value="{{item.id}}">{{item.name}} <list-items data="item.items" ng-if="item.items"></list-items> </li></ul>'
    }
});

app.controller('FlickrContentCtrl', function (ImageListService,ImageInfoService,$scope, $mdDialog) {
    var ctrl = this;
    ctrl.content = [];
    $scope.search_arguments = [];
    $scope.search_arguments.tags = [];


    $scope.keywords = [
        {
            title: 'Animals',
            level1:[
                {   title: 'Pets',
                    level2:[ 'Guppy', 'Parrot']
                },
                {   title: 'Wild animals',
                    level2:[ 'Tiger', 'Ant']
                },
            ]
        },

    ];




    ctrl.fetchContent = function () {
        ImageListService.getData().then(function (result) {

            if( result.data.stat != 'fail'){
                ctrl.content = result.data.photos.photo;
            }

        });
    };

    $scope.appendSearchArgumentsTag = function(item){
        $scope.search_arguments.tags.push(item);

    }
    $scope.removeSearchArgumentsTag = function(index){
        $scope.search_arguments.tags.splice(index, 1)

    }

    $scope.searchImage = function() {
        ImageListService.setSearchArguments($scope.search_arguments)
        ctrl.fetchContent();
    };

    $scope.showAlert = function(event,photo_id) {
        ImageInfoService.getData(photo_id).then(function (result) {

            $mdDialog.show({
                templateUrl: 'html_template/flickr/dialog_info_content.html',
                locals: {
                    result:  result
                },
                parent: angular.element(document.body),
                controller: DialogCtrl,
                targetEvent: event,
            })

        });

        function DialogCtrl($scope,$mdDialog,result, ImageInfoService) {
            $scope.photo_info = result.data.photo;

            $scope.answer = function(answer) {
                $mdDialog.hide(answer);
            };
        }

    };


    ctrl.fetchContent();
});

;var app = angular.module('MyFlickrApp', ['ngMaterial'], function($interpolateProvider,$httpProvider) {
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