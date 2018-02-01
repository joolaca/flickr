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
});