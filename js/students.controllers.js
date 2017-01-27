app.controller('students-controller', function($scope, $http){

    $scope.classData = [];
    $scope.curse = null;
    
    $http.get('libs/class/class-manager.php').success(function(data){
        $scope.classData = data;
    });

    $scope.setData = function(type)
    {
        if(type == 'data')
        {
            if($scope.dtnas.length == 2 || $scope.dtnas.length == 5)
            {
                $scope.dtnas += '-';
            }
        }
    }

    $scope.addStudent = function()
    {

        var objects =
        {
            nome_s: $scope.nome_s,
            dtnas: reverseDate($scope.dtnas),
            tel: $scope.tel,
            npai: $scope.npai,
            fili: $scope.fili,
            telresp: $scope.telresp,
            celresp: $scope.celresp,
            rg: $scope.rg,
            cpf: $scope.cpf,
            email: $scope.email,
            cid: $scope.cid,
            bair: $scope.bair,
            ende: $scope.ende,
            numend: $scope.numend,
            room: $scope.room,
        };

        if(confirm('Tem certeza que deseja adicionar os dados como estão? Em caso de erro apenas o administrador poderá corrigir.'))
        {
            $http({url: 'libs/students/students-manager.php', method: 'POST', data: objects, headers: {'Content-Type': 'x-www-form-urlencoded'}}).success(function(data){
                alert('Dados cadastrados com sucesso');
                var inputs = document.getElementsByTagName('input');
                for(var i=0; i<inputs.length; i++)
                {
                    inputs[i].value = "";
                }
            });
        }

    }

});
