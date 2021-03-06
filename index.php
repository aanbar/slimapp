<?php
// include composer autoload
require_once 'vendor/autoload.php';

// Load .env files
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// Path to views folder
define('VIEW_PATH', __DIR__.'/app/Views');

// start php sessions
session_start();

// load our custom container
$container = new App\Core\Container([
    'settings' => [
        'displayErrorDetails' => env('APP_ENV', 'local') === 'local' ? true : false,
        'determineRouteBeforeAppMiddleware' => true,
        'db' => [
            'driver'    => env('DB_CONNECTION', 'mysql'),
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => env('DB_CHARSET', 'utf8'),
            'collation' => env('DB_COLLATION','utf8_unicode_ci'),
            'prefix'    => env('DB_PREFIX', '')
        ]
    ]
]);

// register flash messages
$container['flash'] = function () {
    return new \Slim\Flash\Messages;
};

// register validation
$container['validator'] = function () {
    return new App\Validation\Validator;
};

// Load Eloquent ORM

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container->settings['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// register in the container
$container['db'] = function () use ($capsule) {
    return $capsule;
};

// create app instance
$app = new Slim\App($container);

// Register auth in container
$container['auth'] = function (){
    return new App\Auth\Auth;
};

// Inject Csrf into container
$container['csrf'] = function () {
    $guard = new \Slim\Csrf\Guard();
    $guard->setFailureCallable(function ($request, $response, $next) {
        $request = $request->withAttribute("csrf_status", false);
        return $next($request, $response);
    });
    return $guard;
};

// register views handler
$container['view'] = function (\Slim\Container $c) {
    $view = new \Slim\Views\Twig(VIEW_PATH, [
        'cache' => false,
    ]);

    $view->addExtension(new Slim\Views\TwigExtension($c->router, $c->request->getUri()));

    // add .env functionality to views.
    $view->addExtension(new class extends \Twig\Extension\AbstractExtension {

        public function getFunctions()
        {
            return [new Twig_Function('env', function ($key, $default=null) {
                return env($key, $default);
            })];
        }

    });
    // register flash messages in views
    $view->getEnvironment()->addGlobal('flash', $c->flash);

    // register auth in views, add values to avoid querying multiple times
    $view->getEnvironment()->addGlobal('auth', [
        'check' => $c->auth->check(),
        'user'  => $c->auth->user()
    ]);

    return $view;
};

// collect validation errors using middleware
$app->add(new App\Middleware\ValidationErrorsMiddleware($container));

// add old form-data collector middleware
$app->add(new App\Middleware\OldInputMiddleware($container));

// register csrf middleware
$app->add(new App\Middleware\CsrfHandlerMiddleware($container));
$app->add($container->csrf);



// Load routes file
require_once 'app/routes.php';

// lunch the app
$app->run();