<?php

namespace Scouterna\ScoutnetMock;

use Tuupola\Middleware\HttpBasicAuthentication;
use Slim\Factory\AppFactory;

class ServerApp
{
    private $app;

    private function __construct()
    {
    }

    public static function run($dbFile)
    {
        $this->sqliteFile = $dbFile;
        $db = new \PDO("sqlite:$dbFile");
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $app = AppFactory::create();

        $app->add(new HttpBasicAuthentication([
            'users' => [
                '1' => 'uihiu23h4i2u3h498fsufs8ef'
            ],
            'before' => function ($request, $arguments) {
                return $request->withAttribute('groupId', $arguments['user']);
            }
        ]));

        $app->get('/api/organisation/group', new GroupInfo($db));
        $app->get('/api/group/memberlist', new Members($db));
        $app->get('/api/group/customlists', new CustomLists($db));

        $app->run();
    }
}
