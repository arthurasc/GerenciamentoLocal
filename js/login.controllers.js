var app = angular.module('app', []);

app.controller('login-controller', function($scope, $http){

    $scope.validacao = function()
    {

        var objects = {l : $scope.login, s : $scope.senha};

        $http({url: 'libs/login.php', method: "POST", data: objects, headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).success(function(data){

            if(Object.keys(data).length > 0)
            {
                if(data[0].id > 0)
                {
                    window.location = 'principal.html#/';
                    localStorage.setItem('id', data[0].id);
                    localStorage.setItem('nome', data[0].login);
                    localStorage.setItem('nivel', data[0].nivel);
                }
            }
            else
            {
                alert('erro');
            }

        });
    }

});