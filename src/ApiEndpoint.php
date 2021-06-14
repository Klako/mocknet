<?php

namespace Scouterna\Mocknet;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Doctrine\ORM\EntityManager;

abstract class ApiEndpoint
{
    /** @var EntityManager */
    protected $entityManager;

    /** @var int */
    protected $groupId;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $this->groupId = $request->getAttribute('groupId');
        return $this->getResponse($request, $response, $args);
    }

    protected abstract function getResponse(Request $request, Response $response, $args): Response;
}
