require(['app/common'], function (angularAMD) {
    'use strict';

    var app = angular.module("app", [
        'ui.router',
        'ngResource',
        'ui.bootstrap',
        'ngAnimate',
        'ngSanitize',
        'angular-loading-bar'
    ]);

    app.constant('appConfig', {
        'URL_BASE': 'web/js/app/',
        'URL_BASE_API_V1': 'api/v1/'
    });

    app.config([
        '$stateProvider',
        '$urlRouterProvider',
        'cfpLoadingBarProvider',
        '$httpProvider',
        'appConfig',
        function (
            $stateProvider,
            $urlRouterProvider,
            cfpLoadingBarProvider,
            $httpProvider,
            appConfig
        ) {
            $httpProvider.defaults.timeout = 10000;
            $httpProvider.interceptors.push(function ($q, $location, $injector) {
                return {
                    responseError: function (response) {
                        var $modalInstance,
                            $modal = $injector.get('$uibModal');

                        $modalInstance = $modal.open({
                            animation: true,
                            templateUrl: appConfig.URL_BASE + "common/modalError.html",
                            controller: function ($scope) {
                                $scope.message = response.statusText;
                                $scope.code = response.status;
                                $scope.time = (new Date()).toISOString();

                                $scope.ok = function (event) {
                                    $modalInstance.close(event);
                                };
                            }
                        });
                        return response;
                    }
                };
            });

            $stateProvider
                .state('home', angularAMD.route({
                    url: '/home',
                    templateUrl: appConfig.URL_BASE  + 'home/home.html'
                }))
                .state('list', angularAMD.route({
                    url: '/list',
                    templateUrl: appConfig.URL_BASE  + 'task/list.html',
                    controllerUrl: 'app/task/taskController'
                }))
                .state('add', angularAMD.route({
                    url: '/add',
                    templateUrl: appConfig.URL_BASE  + 'task/add.html',
                    controllerUrl: 'app/task/taskController'
                }));

            $urlRouterProvider.otherwise('/home');
        }
    ]);

    return angularAMD.bootstrap(app);
});
