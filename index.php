<?php
/**
 * Author: June McIntyre
 * Date: 21/1/2018
 * Time: 9:50 AM
 */

// For on-page error reporting
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

/********************************** INITIAL BOOTSTRAP **********************************/
// Class Inclusions

// Connect to Composer dependencies
require_once __DIR__.'/vendor/autoload.php';

// Grab solution's functions
require_once __DIR__.'/functions.php';

// Create the Silex\Application
$app = new Silex\Application();
$app['debug'] = true;



/*********************************** CONTROLLER DEFs ***********************************/
// Set up Twig Service Provider so we can use it in our routes
$app->register(new Silex\Provider\TwigServiceProvider(), array(
   'twig.path' => __DIR__.'/views'
));

// Sessions...
$app->register(new Silex\Provider\SessionServiceProvider());



/**************************************** DEBUG ****************************************/
# echo "DEBUG-TEST";



/************************************** MIDDLEWARE *************************************/
// If they're not logged in, send em to login
// Attach to routes below by appending ->before($auth_middleware)
// Very general - guests and anyone allowed.
$auth_middleware = function (Request $request, Application $app) {
    $user = $app['session']->get('user');
    if ($user === null)
        return $app->redirect($app["request"]->getBaseUrl() . '/login');
}; // Unused



/*************************************** GENERAL (INDEX) ROUTES ****************************************/
// LoO homepage, just informational
$app->get('/', function() use ($app) {
    return $app['twig']->render('home.twig', array(
       'title' => "LoO Quotes | Home",
       'meta' => "This is the homepage for a Tumblr bot for posting Lessons of October quotes! Lord knows why you're here... Code: https://github.com/new-humans/loo-quotes"
    ));
});

// LoO generation endpoint
$app->get('/gen', function() use ($app) {
    // Decide # of lines to retrieve
    $lineCount = rand(1, 8);

    // Pass LoO URL and lineCount to generator
    $quote = gen("https://junipermcintyre.net/politics/lessons-of-october/download", $lineCount);

    // Return!
    return $quote;
});

// LoO homepage, just informational
$app->get('/post', function() use ($app) {
    // Read Tumblr API

});


// Debug
$app->get('/debug', function() use ($app) {

});

// 404!
$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($code == 404) {
        return $app['twig']->render('404.twig', array (
            'title' => "404 Resource Not Found"
        ));
    } else
        return "{$code} HTTP error! Please inform administrators how this was achieved.";
});

// Run the app - don't delete this!
$app->run();
