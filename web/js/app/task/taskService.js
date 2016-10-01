define(['angularAMD'], function (angularAMD) {
    'use strict';

    angularAMD.service('taskService', function ($http, appConfig, $uibModal) {
        var taskUri = appConfig.URL_BASE_API_V1 + 'task',
            $modalInstance;
        /**
         * @param task
         * @param $scope
         * @returns {*}
         */
        this.get = function (task, $scope) {
            return $http.get(taskUri, task).then(function successCallback(response) {
                $scope.tasks = response.data;
            });
        };

        /**
         * @param task
         * @param $scope
         * @param callback
         * @returns {*}
         */
        this.add = function (task, $scope, callback) {
            return $http.post(taskUri, task).then(function successCallback(response) {
                if (response.status == 200 || response.status == 201) {
                    $modalInstance = $uibModal.open({
                        animation: true,
                        templateUrl: appConfig.URL_BASE + "common/modal.html",
                        controller: function ($scope) {
                            $scope.message = 'Registro Exitoso - id: ' + task.id;

                            $scope.ok = function (event) {
                                $modalInstance.close(event);
                                if (callback !== undefined) {
                                    callback();
                                }
                            };
                        }
                    });
                }
            });
        };

        /**
         * @param task
         * @param $scope
         * @param callback
         * @returns {*}
         */
        this.update = function (task, $scope, callback) {
            return $http.put(taskUri + '/' + task.id , task).then(function successCallback(response) {
                $scope.task = response.data;
                if (callback !== undefined) {
                    callback();
                }
            });
        };
    });
});

