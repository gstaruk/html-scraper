<?php

// Include Composer autoloader
require '../vendor/autoload.php';

// Convert all the command line arguments into a URL
$argv = $GLOBALS['argv'];
array_shift($argv);
$pathInfo = implode('/', $argv);

// Set up default settings array
$settings = [
	// Set up mock environment
	'environment' => \Slim\Http\Environment::mock(['REQUEST_URI' => '/' . $pathInfo])
];

// Initialise Slim App
$app = new Slim\App($settings);

// Get Slim Container
$container = $app->getContainer();

// Define container variables
$container['scrapeUrl'] = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html';

// Set up errorHandler
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
       $x = $response->getBody();
       $x->write('error');
       return $response->withBody($x);
    };
};

// Set up notFoundHandler
$container['notFoundHandler'] = function ($c) {
	return function ($request, $response) use ($c) {
	    $x = $response->getBody();
	    $x->write('command not found');
	    return $response->withBody($x);
   };
};

// Define app routes
$app->map(['GET'], '/process', 'App\Controllers\DefaultController:console');

// Run the app
$app->run();