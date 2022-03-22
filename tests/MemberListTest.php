<?php

use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Scouterna\Mocknet\Api\GroupInfo;
use Scouterna\Mocknet\Api\Members;
use Scouterna\Mocknet\Database\ManagerFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Scouterna\Mocknet\Database\Model;
use Scouterna\Mocknet\Database\Model\Member;
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
        $group->name = "Testgroup";
        self::$entityManager->persist($group);
        foreach (range(1, $nrOfMembers) as $i) {
            $member = new Model\Member();
            self::$entityManager->persist($member);
            $groupMember = new Model\GroupMember($group, $member);
            self::$entityManager->persist($groupMember);
            $group->members->add($groupMember);
        }
        self::$entityManager->flush();

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
            assertIsArray($data[$member->id]);
            $memberObj = $data[$member->id];
            self::checkMemberVal($member->id, $memberObj, 'member_no');
            self::checkMemberVal($member->first_name, $memberObj, 'first_name');
            self::checkMemberVal($member->last_name, $memberObj, 'last_name');
            self::checkMemberVal($member->ssno, $memberObj, 'ssno');
            self::checkMemberVal($member->note, $memberObj, 'note');
            self::checkMemberVal($member->date_of_birth->format('Y-m-d'), $memberObj, 'date_of_birth');
            self::checkMemberVal($member->created_at->format('Y-m-d'), $memberObj, 'created_at');
            assertEquals(Member::STATUS_ARRAY[$member->status], $memberObj['status']);
            assertEquals(Member::SEX_ARRAY[$member->sex], $memberObj['sex']);
            self::checkMemberVal($member->address_1, $memberObj, 'address_1');
            self::checkMemberVal($member->postcode, $memberObj, 'postcode');
            self::checkMemberVal($member->town, $memberObj, 'town');
            self::checkMemberVal($member->country, $memberObj, 'country');
            self::checkMemberVal($member->email, $memberObj, 'email');
            self::checkMemberVal($member->contact_alt_email, $memberObj, 'contact_alt_email');
            self::checkMemberVal($member->contact_mobile_phone, $memberObj, 'contact_mobile_phone');
            self::checkMemberVal($member->contact_home_phone, $memberObj, 'contact_home_phone');
            self::checkMemberVal($member->contact_mothers_name, $memberObj, 'contact_mothers_name');
            self::checkMemberVal($member->contact_email_mum, $memberObj, 'contact_email_mum');
            self::checkMemberVal($member->contact_mobile_mum, $memberObj, 'contact_mobile_mum');
            self::checkMemberVal($member->contact_telephone_mum, $memberObj, 'contact_telephone_mum');
            self::checkMemberVal($member->contact_fathers_name, $memberObj, 'contact_fathers_name');
            self::checkMemberVal($member->contact_email_dad, $memberObj, 'contact_email_dad');
            self::checkMemberVal($member->contact_mobile_dad, $memberObj, 'contact_mobile_dad');
            self::checkMemberVal($member->contact_telephone_dad, $memberObj, 'contact_telephone_dad');
        }
    }

    private static function checkMemberVal($val, $memberObj, $fieldName) {
        if ($val === null) {
            return;
        }
        assertEquals($val, $memberObj[$fieldName]['value']);
    }
}
