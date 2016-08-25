/**
 * Created by smorley on 2016-08-16.
 */

var storeApp = angular.module('RegApp', ['ngRoute']);

storeApp.config(['$routeProvider', function($routeProvider) {
        $routeProvider.
        when('/test', {
            templateUrl: 'test.html',
            controller: storeController
        }).
        when('/form', {
            templateUrl: 'RegForm.html',
            controller: RegController
        }).
        when('/cart', {
            templateUrl: 'test.php',
            controller: storeController
        }).
        otherwise({
            redirectTo: '/test'
        });
    }]);

storeApp.component('textField',
    {
        template: '<div class="form-group" id="{{$ctrl.name}}"><label class="col-sm-2 control-label">{{$ctrl.label}}</label><div class="col-sm-10"><input class="form-control input-sm" name="{{$ctrl.name}}" maxlength="60" size="60" type="text" ng-model="$ctrl.model" ng-required="$ctrl.label.indexOf(\'*\')>0" >{{parent.$ctrl.name}}</div></div>',
        bindings: { label: '@', name: '@', model: '=' },
    }
)
;

storeApp.directive('checkBox', function () {
    return {
        scope: {},
        bindToController: {
            label: '@',
            name: '&',
            values: '=',
            model: '=',
            change: '='
        },
        controller: function () { },
        controllerAs: 'ctrl',
        template: '<div class="form-group"><div class="col-sm-2 control-label"></div><div class="col-sm-10"><div class="checkbox"><label><input type="checkbox"/>{{ctrl.label}}</label> </div> </div> </div>',
    }
});

storeApp.directive('radioOptions', function () {
    return {
        scope: {},
        bindToController: {
            label: '@',
            name: '&',
            values: '=',
            model: '=',
            change: '='
        },
        controller: function () { },
        controllerAs: 'ctrl',
        template: '<div class="form-group"><label class="col-sm-2 control-label">{{ctrl.label}}</label><div class="col-sm-10"><div class="radio"><label ng-repeat="ho in ctrl.values" ><input  value="{{ho.Value}}" name="{{ctrl.name}}" type="radio" ng-change="ctrl.change" ng-model="ctrl.model">{{ho.Label}}&nbsp;&nbsp;</label></div></div></div>',
    }
});

storeApp.directive('optionField', function () {
    return {
        scope: {},
        bindToController: {
            label: '@',
            name: '&',
            values: '=',
            model: '='
        },
        controller: function () { },
        controllerAs: 'ctrl',
        template: '<div class="form-group"><label class="col-sm-2 control-label">{{ctrl.label}}</label><div class="col-sm-10"><select class="form-control" name="ctrl.name" ng-model="ctrl.model" ng-required="ctrl.label.indexOf(\'*\')>0" ><option selected="selected" value="">select ...</option><option ng-repeat="data in ctrl.values" value="{{data.Value}}">{{data.Label}}</option></select></div></div>'
    }
});

storeApp.factory('testFunc', function()
    {
        function msg()
        {
            alert("TestFunc");
        }

    });

function RegController($scope, $routeParams, DataService)
//storeApp.controller('RegController', function ()
{
    $scope.formData = {};
    $scope.pl = pl;

    $scope.Register = function()
    {

        testFunc.msg();

        /*
        PaypalService.initPaymentUI().then(function () {
            PaypalService.makePayment($scope.total(), "Total").then(echo("Success"));
        });
       */

    }

    $scope.ResetPage = function()
    {
        this.formData = {};
    }
}

// create a data service that provides a store and a shopping cart that
// will be shared by all views (instead of creating fresh ones for each view).
storeApp.factory("DataService", function () {

    // create store
    var myStore = new store();

    // create shopping cart
    var myCart = new shoppingCart("AngularStore");

    // enable PayPal checkout
    // note: the second parameter identifies the merchant; in order to use the
    // shopping cart with PayPal, you have to create a merchant account with
    // PayPal. You can do that here:
    // https://www.paypal.com/webapps/mpp/merchant
    myCart.addCheckoutParameters("PayPal", "paypaluser@youremail.com");

    // enable Google Wallet checkout
    // note: the second parameter identifies the merchant; in order to use the
    // shopping cart with Google Wallet, you have to create a merchant account with
    // Google. You can do that here:
    // https://developers.google.com/commerce/wallet/digital/training/getting-started/merchant-setup
    myCart.addCheckoutParameters("Google", "xxxxxxx",
        {
            ship_method_name_1: "UPS Next Day Air",
            ship_method_price_1: "20.00",
            ship_method_currency_1: "USD",
            ship_method_name_2: "UPS Ground",
            ship_method_price_2: "15.00",
            ship_method_currency_2: "USD"
        }
    );

    // enable Stripe checkout
    // note: the second parameter identifies your publishable key; in order to use the
    // shopping cart with Stripe, you have to create a merchant account with
    // Stripe. You can do that here:
    // https://manage.stripe.com/register
    myCart.addCheckoutParameters("Stripe", "pk_test_xxxx",
        {
            chargeurl: "https://localhost:1234/processStripe.aspx"
        }
    );

    // return data object with store and cart
    return {
        store: myStore,
        cart: myCart
    };
});
