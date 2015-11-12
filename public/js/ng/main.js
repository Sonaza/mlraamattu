
/*
 * Application
 */
 
var app = angular.module('adminpanel', ['ngResource', 'ngRoute', 'ui.sortable'],
	function($interpolateProvider)
	{
		// $interpolateProvider.startSymbol('##');
		// $interpolateProvider.endSymbol('##');
	});

app.config(
	function($routeProvider)
	{
		$routeProvider
			.when('/', {
				controller: 'IndexController',
				templateUrl: '/ng/index.html',
			})
			
			.when('/courses', {
				controller: 'CoursesController',
				templateUrl: '/ng/courses/list.html',
			})
			.when('/courses/:id', {
				controller: 'CourseDisplayController',
				templateUrl: '/ng/courses/show.html',
			})
			.when('/courses/:id/edit', {
				controller: 'CoursesFormController',
				templateUrl: '/ng/courses/form.html',
			})
			
			.when('/tests', {
				controller: 'TestsController',
				templateUrl: '/ng/tests/list.html',
			})
			.when('/tests/:id', {
				controller: 'TestsDisplayController',
				templateUrl: '/ng/tests/show.html',
			})
			.when('/tests/new/:course_id', {
				controller: 'TestsFormController',
				templateUrl: '/ng/tests/form.html',
			})
			.when('/tests/:id/edit', {
				controller: 'TestsFormController',
				templateUrl: '/ng/tests/form.html',
			})
			
			////////////////////////////////////////////////
			// Misc
			
			.otherwise({
				redirectTo: '/',
			});
	}
);

// app.directive('ngEnter', function() {
// 	return function(scope, element, attrs) {
// 		element.bind("keydown keypress", function(event) {
// 			if(event.which === 13) {
// 				scope.$apply(function(){
// 					scope.$eval(attrs.ngEnter);
// 				});

// 				event.preventDefault();
// 			}
// 		});
// 	};
// });

// app.directive('ngBlur', ['$parse', function($parse) {
// 	return function(scope, element, attr) {
// 		var fn = $parse(attr['ngBlur']);
// 		element.bind('blur', function(event) {
// 			scope.$apply(function() {
// 				fn(scope, {$event:event});
// 			});
// 		});
// 	}
// }]);
