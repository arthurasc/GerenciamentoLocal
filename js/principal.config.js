app.config(function($routeProvider){

    $routeProvider
        .when('/users', { templateUrl : 'pages/manager/users-control.html' })
        .when('/class', { templateUrl : 'pages/manager/class-control.html' })
        .when('/students', { templateUrl : 'pages/manager/students-control.html' })
        .when('/financial', { templateUrl : 'pages/manager/financial-control.html' })
        .when('/surveys', { templateUrl : 'pages/manager/surveys-control.html' });

});