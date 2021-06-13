<?php

namespace Scouterna\Mocknet;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

abstract class ApiEndpoint
{
    /** @var \PDO */
    protected $db;

    /** @var int */
    protected $groupId;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $this->groupId = $request->getAttribute('groupId');
        return $this->getResponse($request, $response, $args);
    }

    protected abstract function getResponse(Request $request, Response $response, $args): Response;
}
