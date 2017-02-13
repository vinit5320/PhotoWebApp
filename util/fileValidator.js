/**
 * Created by xiangwang on 1/24/17.
 */

(function () {
    'use strict';
    angular
        .module('ui.fileValidator', [])
        .component('fileValidate', {
            template: '<span ng-show="$ctrl.invalid"><span style="color: dodgerblue">{{$ctrl.file.name}}</span> size exceed limit : </span>' +
            '<span ng-show="$ctrl.file.size > 0" ng-switch="$ctrl.file.size > 1024 * 1024" ng-style="$ctrl.invalid ? {\'color\': \'red\'} : {\'color\': \'green\'}">' +
            '<span ng-switch-when="true"> {{$ctrl.file.size / (1024 * 1024) | number : 2}} MB </span>' +
            '<span ng-switch-default> {{$ctrl.file.size / 1024 | number : 2}} KB </span> </span>',
            bindings: {
                file: '<',
                sizeLimitMb: '<',
                invalidModel: '='
            },
            controller: FileValidatorController
        });

    function FileValidatorController() {
        var $ctrl = this;
        $ctrl.$onChanges = function () {
            if ($ctrl.file) {
                $ctrl.invalid = $ctrl.file.size > (1024 * 1024) * $ctrl.sizeLimitMb;
                $ctrl.invalidModel = $ctrl.invalid;
            }
        }
    }
})();