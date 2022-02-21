<?php

use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Scouterna\Mocknet\Api\GroupInfo;
use Scouterna\Mocknet\Api\Members;
use Scouterna\Mocknet\Database\ManagerFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Scouterna\Mocknet\Database\Model;
use Slim\Psr7\Response;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsObject;
use function PHPUnit\Framework\assertJson;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertThat;

class MemberListTest extends TestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    private static $entityManager;

    /** @var \Scouterna\Mocknet\Api\Members */
    private static $endpoint;

    /** @var \Slim\Psr7\Request */
    private static $request;

    public static function setUpBeforeClass(): void
    {
        $factory = new ManagerFactory();
        $factory->setConnection([
            'driver' => 'pdo_sqlite',
            'path' => ':memory:'
        ]);
        self::$entityManager = $factory->makeManager();
        $metadataFactory = self::$entityManager->getMetadataFactory();
        $tool = new SchemaTool(self::$entityManager);
        $tool->updateSchema($metadataFactory->getAllMetadata());
        self::$endpoint = new Members(self::$entityManager);
        $requestFactory = new ServerRequestFactory();
        self::$request = $requestFactory->createServerRequest('GET', '/');
    }

    protected function tearDown(): void
    {
        self::$entityManager->clear();
        self::$entityManager->flush();
        self::$entityManager->close();
    }

    public function testGroupMembers()
    {
        $nrOfMembers = 10;
        $group = new Model\ScoutGroup();
        self::$entityManager->persist($group);
        foreach (range(0, $nrOfMembers) as $i) {
            $member = new Model\Member();
            self::$entityManager->persist($member);
            $groupMember = new Model\GroupMember($group, $member);
            self::$entityManager->persist($groupMember);
            $group->members->add($groupMember);
        }

        $request = self::$request->withAttribute('groupId', $group->id);
        $apiResponse = self::$endpoint->__invoke($request, new Response(), []);
        $response = $apiResponse->getBody()->__toString();
        assertJson($response);
        $result = json_decode($response, true);
        
        assertIsArray($result['data']);
        $data = $result['data'];
        assertCount(10, $data);

        foreach ($group->members as $groupMember) {
            $member = $groupMember->member;
            assertArrayHasKey($member->id, $data);
            assertIsObject($data[$member->id]);
            $memberObj = $data[$member->id];
        }
    }
}
