app.controller('financial-controller', function($scope, $http){

});

app.controller('payments-controller', function($scope, $http) {

    $scope.students = [];

    $scope.searchStudent = function()
    {
        if($scope.search.length > 0)
        {
            $http.get('libs/financial/financial-manager.php?s=' + $scope.search + '&p').success(function(data){
                for(var i=0; i<Object.keys(data).length; i++)
                {
                    data[i].venc = reverseDate(data[i].venc);
                }
                $scope.students = data;
            });
        }
        else
        {
            $scope.students = [];
        }
    }

    $scope.paymentParcel = function(vencimento, id, index, valor, desconto, aluno_id)
    {
        var objects = {
                id: id,
                ano: vencimento.split('-')[2],
                mes: vencimento.split('-')[1],
                dia: vencimento.split('-')[0],
                valor: valor,
                desconto: desconto,
                aluno: aluno_id
            };

        if(confirm('Ao continuar você concorda com o RECEBIMENTO DA MENSALIDADE INTEGRAL e a operação não poderá ser desfeita, DESEJA CONTINUAR?'))
        {
            $http({url: 'libs/financial/financial-manager.php?b', method: 'POST', data: objects, headers: {'Content-Type': 'x-www-form-ulencoded'}}).success(function(data){
                $scope.students.splice(index, 1);
            });
        }
    }

});

app.controller('generate-controller', function($scope, $http){

    $scope.students = [];
    $scope.financialId = null;
    $scope.addVencimento = false;
    $scope.venc = {};

    $scope.searchStudent = function()
    {
        $scope.addVencimento = false;
        $scope.venc.date = '';

        if($scope.search.length > 0)
        {
            $http.get('libs/financial/financial-manager.php?s=' + $scope.search).success(function(data){
                $scope.students = data;
            });
        }
        else
        {
            $scope.students = [];
        }
    }

    $scope.generateFinancial = function(X, Y, Z)
    {
        $scope.financialId = X;
        $scope.financialValor = Y;
        $scope.financialDes = Z;
        $scope.addVencimento = true;
    }

    $scope.confirmDate = function()
    {
        if(confirm('Ao continuar você concorda com o RECEBIMENTO REFERENTE AO VALOR DA PRIMEIRA PAARCELA e a OPERAÇÃO NÃO PODERÁ SER DESFEITA, ainda assim DESEJA CONTINUAR?'))
        {
            $http.get('libs/financial/financial-manager.php?v=' + $scope.venc.date + '&i=' + $scope.financialId + '&vl=' + $scope.financialValor + '&des=' + $scope.financialDes).success(function(){
                alert('Operação realizada com sucesso.');
                $scope.financialId = null;
                $scope.addVencimento = false;
                $scope.venc.date = '';
                $scope.search = '';
                $scope.students = [];
            });
        }
    }

});