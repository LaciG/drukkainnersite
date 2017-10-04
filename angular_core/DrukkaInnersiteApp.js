var drukkaApp = angular.module("DrukkaInnsersite", ["ngRoute", "ngAnimate"]);

drukkaApp.config(function($routeProvider, $locationProvider) {
	$locationProvider.html5Mode({
		enabled: false, 
		requireBase: true
	});

	$routeProvider
		.when("/", {
			templateUrl: "mvc/view/Home.html", 
			controller: "HomeController"
		})
		.when("/test", {
			templateUrl: "mvc/view/Test.html", 
			controller: "TestController"
		})
		.otherwise({
			templateUrl: "mvc/view/404.html"
		})
});