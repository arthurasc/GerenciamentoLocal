app.controller('users-controller', function($scope, $http){

    $scope.usersData = [];
    $scope.nivelFilter = null;

    $http.get('libs/users/users-manager.php').success(function(data){
        $scope.usersData = data;
    });

    $scope.deleteUser = function(id, table, index) {
        if(confirm('Tem certeza de que deseja excluir o usuário?'))
        {
            $http.get('libs/tools/exclusions.php?i=' + id + '&t=' + table).success(function(data){
                $scope.usersData.splice(index, 1)
            });
        }
    }

    $scope.addUser = function()
    {
        var objects = {l : $scope.n, n : $scope.nivel};

        $http({url: 'libs/users/users-manager.php', method : 'POST', data : objects, headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).success(function(data){
            $scope.n = "";
            $scope.usersData = data;
        });
    }

    $scope.getLevel = function(X)
    {
        $scope.nivel = X;
    }

    $scope.getFilterLevel = function(X)
    {
        $scope.nivelFilter = X;
    }

});
