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

    public static function run($connection, $groupId, $apiKey)
    {
        $managerFactory = new ManagerFactory();
        $managerFactory->setConnection($connection);
        $entityManager = $managerFactory->makeManager();

        $app = AppFactory::create();

        $app->add(new HttpBasicAuthentication([
            'path' => ['/api/organisation', '/api/group'],
            'users' => [
                $groupId => $apiKey
            ],
            'before' => function ($request, $arguments) {
                return $request->withAttribute('groupId', $arguments['user']);
            }
        ]));

        $app->any('/api/authenticate', new Api\Authenticate($entityManager));
        $app->get('/api/organisation/group', new Api\GroupInfo($entityManager));
        $app->get('/api/group/memberlist', new Api\Members($entityManager));
        $app->get('/api/group/customlists', new Api\CustomLists($entityManager));

        $app->run();
    }
}
