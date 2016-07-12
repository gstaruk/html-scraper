<?php

// Include Composer autoloader
require '../vendor/autoload.php';

// Set up Slim Container
$container = new \Slim\Container;

// Define container variables
$container['scrapeUrl'] = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html';

// Initialise Slim App
$app = new Slim\App($container);

// Define app routes
$app->get('/', 'App\Controllers\DefaultController:home');

// Run the app
$app->run();