<?php

use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Scouterna\Mocknet\Api\Authenticate;
use Scouterna\Mocknet\Database\Model;
use Scouterna\Mocknet\Database\ManagerFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;

class AuthenticateTest extends TestCase
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
            'path' => ':memory:'
        ]);
        self::$entityManager = $factory->makeManager();
        $metadataFactory = self::$entityManager->getMetadataFactory();
        $tool = new SchemaTool(self::$entityManager);
        $tool->updateSchema($metadataFactory->getAllMetadata());
        self::$endpoint = new Authenticate(self::$entityManager);
        $requestFactory = new ServerRequestFactory();
        self::$request = $requestFactory->createServerRequest('GET', '/');
    }

    protected function tearDown(): void
    {
        self::$entityManager->clear();
        self::$entityManager->flush();
        self::$entityManager->close();
    }

    public function testLogin() {
        $member = new Model\Member();
        self::$entityManager->persist($member);
        self::$entityManager->flush();

        $request = self::$request->withQueryParams([
            'username' => $member->id,
            'password' => $member->password,
        ]);
        $apiResponse = self::$endpoint->__invoke($request, new Response(), []);
        $response = $apiResponse->getBody()->__toString();
        $result = json_decode($response, true);

        assertArrayHasKey('token', $result, $response);
        assertEquals($member->jwt_token, $result['token']);
        assertArrayHasKey('member', $result);
        assertEquals($member->id, $result['member']['member_no']);
        assertEquals($member->first_name, $result['member']['first_name']);
        assertEquals($member->last_name, $result['member']['last_name']);
        assertEquals($member->email, $result['member']['email']);
    }
}
