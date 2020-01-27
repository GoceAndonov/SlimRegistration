<?php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use src\Models\User;
use src\Models\Pixel;
use Illuminate\Database\Capsule\Manager;

session_start();

require __DIR__ . '/../vendor/autoload.php';

    $app = new \Slim\App([
	'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
		'displayErrorDetails' => true,
		// MySQL Settings
		'db' => [
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'slimchallange',
			'username'  => 'root',
			'password'  => '',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		],
        'mailer' => [
            'host' => getenv('smtp.gmail.com'),
            'username' => getenv('goce.andonov.fnk@gmail.com'),
            'password' => getenv('1504993464017fnk!')
        ],
        'baseUrl' => getenv('BASE_URL')
	],
]);

    //Eloquent ORM Settings
    $container = $app->getContainer();

    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container->get('settings')['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    $container['db'] = function ($container) use ($capsule){
        return $capsule;
    };

    //Twig View. Setting the twig templates folder
    $container['view'] = function ($container){
        $view = new \Slim\Views\Twig(__DIR__ . '/../templates');
        $view->addExtension(new \Slim\Views\TwigExtension(
            $container->router,
            $container->request->getUri()
        ));
        return $view;
    };

    $container['LoginController'] = function($container){
        return new \Src\Controllers\LoginController($container->view);
    };

    $container['RegisterController'] = function($container){
        return new \Src\Controllers\RegisterController($container->view);
    };

    $container['mailer'] = function($container) {
        return new Nette\Mail\SmtpMailer($container['settings']['mailer']);
    };

    $container[User::class] = function ($container) {
        $view = $container->get('view');
        $logger = $container->get('logger');
        $table = $container->get('db')->table('table_name');
        return new \App\User($view, $logger, $table);
    };
    require __DIR__ . '/../src/routes.php';
