<?php
declare(strict_types=1);

use App\Application\Actions\Doctor\ListDoctorsAction;
use App\Application\Actions\Hexagon\AddHexagonAction;
use App\Application\Actions\Hexagon\DeleteHexagonAction;
use App\Application\Actions\Hexagon\ListHexagonsAction;
use App\Application\Actions\Hexagon\ViewHexagonAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        return phpinfo();
    });
    $app->group('/server/api', function(Group $group) {
        $group->options('/{routes:.*}', function (Request $request, Response $response) {
            // CORS Pre-Flight OPTIONS Request Handler
            return $response;
        });

        $group->group('/hexagons', function (Group $group) {
            $group->get('', ListHexagonsAction::class);
            $group->post('', AddHexagonAction::class);
            $group->delete('/{name}', DeleteHexagonAction::class);
            $group->get('/{id}', ViewHexagonAction::class);
        });
    });
};
