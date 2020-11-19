<?php

namespace Config;

/**
 * --------------------------------------------------------------------
 * URI Routing
 * --------------------------------------------------------------------
 * This file lets you re-map URI requests to specific controller functions.
 *
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *    example.com/class/method/id
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 */

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 * The RouteCollection object allows you to modify the way that the
 * Router works, by acting as a holder for it's configuration settings.
 * The following methods can be called on the object to modify
 * the default operations.
 *
 *    $routes->defaultNamespace()
 *
 * Modifies the namespace that is added to a controller if it doesn't
 * already have one. By default this is the global namespace (\).
 *
 *    $routes->defaultController()
 *
 * Changes the name of the class used as a controller when the route
 * points to a folder instead of a class.
 *
 *    $routes->defaultMethod()
 *
 * Assigns the method inside the controller that is ran when the
 * Router is unable to determine the appropriate method to run.
 *
 *    $routes->setAutoRoute()
 *
 * Determines whether the Router will attempt to match URIs to
 * Controllers when no specific route has been defined. If false,
 * only routes that have been defined here will be available.
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//*** Librerias */
//*** Librerias */
$routes->group('lib', function ($routes) {
	$routes->get('curl_get', 'MyLibraries::curl_get');
	$routes->get('curl_post', 'MyLibraries::curl_post');
	$routes->get('curl_put', 'MyLibraries::curl_put');
	$routes->get('curl_put', 'MyLibraries::curl_put');
	$routes->get('curl_remove', 'MyLibraries::curl_remove');
	$routes->get('agent', 'MyLibraries::agent');
	$routes->get('email', 'MyLibraries::email');
	$routes->get('encrypt', 'MyLibraries::encrypt');
	$routes->get('time', 'MyLibraries::time');
	$routes->get('uri', 'MyLibraries::uri');
	$routes->get('file', 'MyLibraries::file');
});

//$routes->get('/contacto', 'Home::contacto');
$routes->get('/contacto/(:any)', 'Home::contacto/$1', ['as' => 'contacto']);

$routes->get('/image', 'Home::image');
$routes->get('/image/(:num)/(:any)', 'Home::image/$1/$2', ['as' => 'get_image']);
$routes->get('/movie/image/(:num)', 'Movie::delete_image/$1', ['as' => 'image_delete']);
$routes->group('dashboard', function ($routes) {

	//$routes->get('movie', 'dashboard/MovieController::index');
	//$routes->get('movie/test/(:any)', 'dashboard/MovieController::test/$1');
	//$routes->get('movie/show/', 'dashboard/MovieController::show/');
});

$routes->resource('movie');
$routes->resource('category', ['except' => ['show']]);
$routes->resource('client', ['except' => ['show']]);

//***REST */
$routes->get('rest-movie/paginate','RestMovie::paginate');
$routes->get('rest-movie/search','RestMovie::search');

$routes->resource('rest-movie', ['controller' => 'RestMovie']);



$routes->get('/login', 'web/User::login', ['as' => 'user_login_get']);
$routes->post('/login_post', 'web/User::login_post', ['as' => 'user_login_post']);
$routes->post('/logout', 'web/User::logout', ['as' => 'user_logout']);


//helpers
$routes->get('/helper/array', 'Myhelper::array');
$routes->get('/helper/filesystem', 'Myhelper::filesystem');
$routes->get('/helper/number', 'Myhelper::number');
$routes->get('/helper/text', 'Myhelper::text');
$routes->get('/helper/url', 'Myhelper::url');

//**********/ Store */
$routes->get('/', 'Store/Movie::index', ['as' => 'store_movie_index']);

$routes->group('store', function ($routes) {

	// stripe
	$routes->get('movie/stripe/client_secret_stripe/(:num)', 'Store\Movie::client_secret_stripe/$1', ['as' => 'store_client_secret_stripe']);
	$routes->get('movie/stripe/show_stripe/(:num)', 'Store\Buyed::show_stripe/$1', ['as' => 'store_show_stripe']);
	$routes->post('movie/stripe/buy_success/(:num)', 'Store\Movie::buy_success_stripe/$1', ['as' => 'store_movie_buy_success']);

	$routes->get('pay/stripe/(:num)', 'Store\Movie::form_stripe/$1', ['as' => 'store_movie_form_stripe']);
	$routes->get('(:num)', 'Store\Movie::show/$1', ['as' => 'store_movie_show']);
	$routes->get('movie/buy/(:num)', 'Store\Movie::buy/$1', ['as' => 'store_movie_buy']);
	$routes->get('movie/buy_success/(:num)', 'Store\Movie::buy_success/$1', ['as' => 'store_movie_buy_success']);
	$routes->get('movie/buy_cancel/(:num)', 'Store\Movie::buy_cancel/$1', ['as' => 'store_movie_buy_cancel']);

	//*Buyed */
	$routes->get('buyed', 'Store\Buyed::index', ['as' => 'store_buyed_index']);
	$routes->get('buyed/(:num)', 'Store\Buyed::show/$1', ['as' => 'store_buyed_show']);
});


// CRUD generico
$routes->resource('categoryautocrud', ['controller' => 'CategoryAutoCRUD']); 



/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
