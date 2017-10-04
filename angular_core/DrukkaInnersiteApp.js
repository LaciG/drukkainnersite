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
		.when("/ui", {
			templateUrl: "mvc/view/Ui.html",
			controller: "UiController"
		})
		.when("/grid", {
			templateUrl: "mvc/view/Grid.html",
			controller: "GridController"
		})
		.when("/tables", {
			templateUrl: "mvc/view/Tables.html",
			controller: "TablesController"
		})
		.when("/stats", {
			templateUrl: "mvc/view/Stats.html",
			controller: "StatsController"
		})
		.when("/docs", {
			templateUrl: "mvc/view/Docs.html",
			controller: "DocsController"
		})
		.otherwise({
			templateUrl: "mvc/view/404.html"
		})
});