/**
 * Created by Vinit Jasoliya on 02/12/17.
 */
(function () {
    'use strict';

    angular
        .module('PHOTOAPP')
        .controller('MainController', MainController);

    MainController.$inject = ['$uibModal', '$scope', 'WebService', '$state'];
    /* @ngInject */
    function MainController($uibModal, $scope, WebService, $state) {
        var $ctrl = this;
    }

})();

