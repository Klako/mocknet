<?php

use PHPUnit\Framework\TestCase;
use Scouterna\Mocknet\Api\GroupInfo;
use Scouterna\Mocknet\Database\ManagerFactory;
use Scouterna\Mocknet\Database\Model;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;
use Doctrine\ORM\Tools\SchemaTool;

class GroupInfoTest extends TestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    private static $entityManager;

    /** @var \Scouterna\Mocknet\Api\GroupInfo */
    private static $endpoint;

    /** @var \Slim\Psr7\Request */
    private static $request;

    public static function setUpBeforeClass(): void
    {
        $factory = new ManagerFactory();
        $factory->setConnection([
            'driver' => 'pdo_sqlite',
            'path' => 'db.sqlite'
        ]);
        self::$entityManager = $factory->makeManager();
        $metadataFactory = self::$entityManager->getMetadataFactory();
        $tool = new SchemaTool(self::$entityManager);
        $tool->updateSchema($metadataFactory->getAllMetadata());
        self::$endpoint = new GroupInfo(self::$entityManager);
        $requestFactory = new ServerRequestFactory();
        self::$request = $requestFactory->createServerRequest('GET', '/');
    }

    protected function tearDown(): void
    {
        self::$entityManager->clear();
        self::$entityManager->flush();
        self::$entityManager->close();
    }

    public function testSimpleGroup()
    {
        $group = new Model\ScoutGroup();
        $group->name = ($groupName = "Flabbergasted");
        self::$entityManager->persist($group);
        $groupLeaderMember = new Model\Member();
        self::$entityManager->persist($groupLeaderMember);
        $groupLeader = new Model\GroupMember($group, $groupLeaderMember);
        self::$entityManager->persist($groupLeader);
        self::$entityManager->flush();

        $request = self::$request->withAttribute('groupId', $group->id);
        $apiResponse = self::$endpoint->__invoke($request, new Response(), []);
        $response = $apiResponse->getBody()->__toString();
        $result = json_decode($response, true);

        self::assertEquals($groupName, $result['Group']['name']);
    }
}
