<?php
declare(strict_types=1);


use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Actions\Home\HomeAction;
use App\Application\Actions\Home\HomeController;


return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->map(['GET', 'POST'],'/', HomeController::class);
};
