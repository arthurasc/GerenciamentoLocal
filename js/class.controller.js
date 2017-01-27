app.controller('class-controller', function($scope, $http){

    $scope.classData = [];
    $scope.class = null;

    $http.get('libs/class/class-manager.php').success(function(data){
        $scope.classData = data;
    });

    $scope.addClass = function()
    {

        var objects = {
            s : $scope.sala,
            c : $scope.curso,
            h : $scope.horario,
            v : $scope.valor.replace(",", "."),
            d : $scope.desconto.replace(",", ".")
        };

        $http({url: 'libs/class/class-manager.php', method: 'POST', data: objects, headers: {'Content-Type': 'x-www-form-urlencoded'}}).success(function(data){

            $scope.sala = "";
            $scope.curso = "";
            $scope.horario = "";
            $scope.valor = "";
            $scope.desconto = "";

            $scope.classData = data;

        });
    }

    $scope.deleteClass = function(id, table, index) {
        if(confirm('Tem certeza de que deseja excluir o usuário?'))
        {
            $http.get('libs/tools/exclusions.php?i=' + id + '&t=' + table).success(function(data){
                $scope.classData.splice(index, 1)
            });
        }
    }

    $scope.getClass = function(X)
    {
        $scope.class = X;
    }

});
