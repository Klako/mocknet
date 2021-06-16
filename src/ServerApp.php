<?php

namespace Scouterna\Mocknet;

use Scouterna\Mocknet\Database\ManagerFactory;
use Tuupola\Middleware\HttpBasicAuthentication;
use Slim\Factory\AppFactory;

class ServerApp
{
    private $app;

    private function __construct()
    {
    }

    public static function run($connection)
    {
        $managerFactory = new ManagerFactory();
        $managerFactory->setConnection($connection);
        $entityManager = $managerFactory->makeManager();

        $app = AppFactory::create();

        $app->add(new HttpBasicAuthentication([
            'users' => [
                '1' => 'uihiu23h4i2u3h498fsufs8ef'
            ],
            'before' => function ($request, $arguments) {
                return $request->withAttribute('groupId', $arguments['user']);
            }
        ]));

        $app->get('/api/organisation/group', new Api\GroupInfo($entityManager));
        $app->get('/api/group/memberlist', new Api\Members($entityManager));
        $app->get('/api/group/customlists', new Api\CustomLists($entityManager));

        $app->run();
    }
}
