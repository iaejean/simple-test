define([], function () {
    'use strict';
    
    return function (params) {
        if (params !== undefined) {
            this.id = params.id || null;
            this.description  = params.description || null;
            this.executionTime = params.executionTime || null;
            this.finished = params.finished || null;

            return this;
        }

        this.id = null;
        this.description = null;
        this.executionTime = null;
        this.finished = null;

        return this;
    };
});
