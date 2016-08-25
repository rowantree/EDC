/**
 * Created by smorley on 2016-08-16.
 *
 *
 *
 *
 * NONE FUNCTIONAL
 */

var myApp = angular.module('RegForm', [])

.component('xxxtextField',
    {
        template: '<div class="form-group" id="{{$ctrl.name}}"><label class="col-sm-2 control-label">{{$ctrl.label}}</label><div class="col-sm-10"><input class="form-control input-sm" name="{{$ctrl.name}}" maxlength="60" size="60" type="text" ng-model="$ctrl.model" ng-required="$ctrl.label.indexOf(\'*\')>0" >{{parent.$ctrl.name}}</div></div>',
        bindings: { label: '@', name: '@', model: '=' },
    }
)
;

myApp.directive('textField', function() {
    return {
        scope: {},
        bindToController: {
            label: '@',
            name: '@',
            type: '@',
            model: '='
        },
        controller: function () {
            this.type = angular.isDefined(this.type) ? this.type : 'text';
        },
        controllerAs: 'ctrl',
        template: '<div class="form-group" id="{{ctrl.name}}"><label class="col-sm-2 control-label">{{ctrl.label}}</label><div class="col-sm-10"><input class="form-control input-sm" name="{{ctrl.name}}" maxlength="60" size="60" type="ctrl.type" ng-model="ctrl.model" ng-required="ctrl.label.indexOf(\'*\')>0" >{{parent.ctrl.name}}</div></div>',
    }
})
;

myApp.directive('checkBox', function () {
    return {
        scope: {},
        bindToController: {
            label: '@',
            name: '@',
            values: '=',
            model: '=',
            change: '='
        },
        controller: function () { },
        controllerAs: 'ctrl',
        template: '<div class="form-group"><div class="col-sm-2 control-label">Label</div><div class="col-sm-10"><div class="checkbox"><label><input type="checkbox"/>{{ctrl.label}}</label> </div> </div> </div>',
    }
});

myApp.directive('radioOptions', function () {
    return {
        scope: {},
        bindToController: {
            label: '@',
            name: '@',
            values: '=',
            model: '=',
        },
        controllerAs: 'ctrl',
        controller: function () {
            },
        template: '<div class="form-group"><label class="col-sm-2 control-label">{{ctrl.label}}</label><div class="col-sm-10"><div class="radio"><label ng-repeat="ho in ctrl.values" ><input  value="{{ho.Value}}" name="{{ctrl.name}}" type="radio" ng-change="ctrl.change" ng-model="ctrl.model" ng-required="{{ctrl.label.indexOf(\'*\')>0}}">{{ho.Label}}&nbsp;&nbsp;</label></div></div></div>',
    }
});

myApp.directive('optionField', function () {
    return {
        scope: {},
        bindToController: {
            label: '@',
            name: '@',
            values: '=',
            model: '='
        },
        controller: function () { },
        controllerAs: 'ctrl',
        template: '<div class="form-group"><label class="col-sm-2 control-label">{{ctrl.label}}</label><div class="col-sm-10"><select class="form-control" name="{{ctrl.name}}" ng-model="ctrl.model" ng-required="{{ctrl.label.indexOf(\'*\')>0}}" ><option selected="selected" value="">select ...</option><option ng-repeat="data in ctrl.values" value="{{data.Value}}">{{data.Label}}</option></select></div></div>'
    }
});

    myApp.controller('RegController', ['$http',
        function ($http)
    {
        console.log("RegController");
        this.formData = {};
        this.formData.firstName = "Stephen";
        this.formData.lastName = "Morley";
        this.formData.city = "Redding";
        this.formData.zipcode = "06896";
        this.formData.state = "CT";
        this.pl = pl;

        this.formData.amountDue = "125.00";
        this.formData.event = "EDC Event 1";

        this.status = "Ready";
        this.data = "n/a";


        this.GetSession = function() {
            this.status = "Calling";

            var thisData = this;

            var url = "GetSession.php";

            $http.get(url)
                .success(function(data, status, headers, config)
                {
                    thisData.status = status;
                    if ( data.json_error_code )
                    {
                        thisData.data = data.json_error_code;
                    }
                    else {
                        thisData.formData = data;
                    }
                })
                .error(function(data, status, headers, config)
                {
                    console.log('Data: ' + data);
                    console.log('Status: ' + status);
                    console.log('Headers: ' + headers);
                    console.log('Config: ' + config);
                })
            ;

        };


        this.GetSession();

        this.Register = function()
        {
            submit();
        }

        this.ResetPage = function()
        {
            console.log("ResetPage");
            this.formData = {};
        }

        this.SubmitForm = function()
        {
            console.log("this.SubmitForm");
            return false;
        }
    }]);

