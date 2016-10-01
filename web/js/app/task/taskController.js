define(['angularAMD', 'app/task/task', 'app/task/taskService'], function (angularAMD, Task) {
    'use strict';

    angularAMD.controller('taskController', [
        '$scope',
        'taskService',
        function (
            $scope,
            taskService
        ) {
            $scope.tasks = [];
            $scope.task = new Task();
            $scope.check = false;

            $scope.get = function (task) {
                taskService.get(task, $scope);
            };
            
            $scope.update = function (task, check) {
                task.finished = check;
                taskService.update(task, $scope, function () {
                    $scope.get(new Task());
                });
            };

            $scope.add = function () {
                taskService.add($scope.task, $scope, function () {
                    $scope.reset();
                });
            };

            $scope.reset = function () {
                $scope.task = new Task();
            };

            $scope.get(new Task());
        }
    ]);
});