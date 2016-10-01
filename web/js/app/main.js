'use strict';

var config = {
        baseUrl: 'web/js/',
        useStrict: true,
        packages : [
            { name : 'app', location : 'app' },
            { name : 'req', location : 'libs/requirejs' }
        ],
        paths: {
            angular: 'libs/angular/angular.min',
            angularRoute: 'libs/angular-route/angular-route.min',
            angularAMD: 'libs/angularAMD/angularAMD',
            angularUIRouter: 'libs/angular-ui-router/release/angular-ui-router.min',
            angularResource: 'libs/angular-resource/angular-resource.min',
            angularAnimate: 'libs/angular-animate/angular-animate.min',
            angularSanitize: 'libs/angular-sanitize/angular-sanitize.min',
            angularLoadingBar: 'libs/angular-loading-bar/build/loading-bar.min',
            uiBootstrap: 'libs/angular-bootstrap/ui-bootstrap.min',
            uiBootstrapTlp: 'libs/angular-bootstrap/ui-bootstrap-tpls.min'
        },
        shim: {
            angularRoute: ['angular'],
            angularAMD: ['angular'],
            angularAnimate: ['angular'],
            angularUIRouter: ['angular'],
            angularResource: ['angular'],
            angularSanitize: ['angular'],
            angularLoadingBar: ['angular'],
            uiBootstrap: ['angular'],
            uiBootstrapTlp: ['uiBootstrap']
        },
        deps: ['app/app']
    };

//JUST FOR DEV
config.urlArgs = 'IAN=' + (new Date()).getTime();

require.config(config);
