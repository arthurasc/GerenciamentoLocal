app.controller('queries-controller', function($scope, $http){

    $scope.search = false;
    $scope.students = [];
    $scope.selectStudent = false;

    $scope.searchStudent = function()
    {
        $scope.selectStudent = false;
        if($scope.searchValue.length > 0)
        {
            $scope.search = true;
            $http.get('libs/queries/queries-manager.php?s=' + $scope.searchValue).success(function(data){
                $scope.students = data;
            });
        }
        else
        {
            $scope.search = false;
            $scope.students = [];
        }
    }

    $scope.onSelectStudent = function(id)
    {
        $scope.search = false;
        $scope.selectStudent = true;

        $http.get('libs/queries/queries-manager.php?si&i=' + id).success(function(data){
            $scope.students = data;
        });
    }

});
