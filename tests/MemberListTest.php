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
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsObject;
use function PHPUnit\Framework\assertJson;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertThat;

class MemberListTest extends TestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var \Scouterna\Mocknet\Api\Members */
    private $endpoint;

    /** @var \Slim\Psr7\Request */
    private $request;

    protected function setUp(): void
    {
        $factory = new ManagerFactory();
        $factory->setConnection([
            'driver' => 'pdo_sqlite',
            'path' => ':memory:'
        ]);
        $this->entityManager = $factory->makeManager();
        $metadataFactory = $this->entityManager->getMetadataFactory();
        $tool = new SchemaTool($this->entityManager);
        $tool->updateSchema($metadataFactory->getAllMetadata());
        $this->endpoint = new Members($this->entityManager);
        $requestFactory = new ServerRequestFactory();
        $this->request = $requestFactory->createServerRequest('GET', '/');
    }

    protected function tearDown(): void
    {
        $this->entityManager->clear();
        $this->entityManager->flush();
        $this->entityManager->close();
    }

    public function testGroupMembers()
    {
        $nrOfMembers = 10;
        $group = new Model\ScoutGroup();
        $group->name = "Testgroup";
        $this->entityManager->persist($group);
        foreach (range(1, $nrOfMembers) as $i) {
            $member = new Model\Member();
            $this->entityManager->persist($member);
            $groupMember = new Model\GroupMember($group, $member);
            $this->entityManager->persist($groupMember);
            $group->members->add($groupMember);
        }
        $this->entityManager->flush();

        $request = $this->request->withAttribute('groupId', $group->id);
        $apiResponse = $this->endpoint->__invoke($request, new Response(), []);
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

    public function testTroopRelation() {
        $em = $this->entityManager;
        $group = new Model\ScoutGroup();
        $em->persist($group);
        $member = new Model\Member();
        $em->persist($member);
        $groupMember = new Model\GroupMember($group, $member);
        $em->persist($groupMember);
        $troop = new Model\Troop($group);
        $em->persist($troop);
        $troopMember = new Model\TroopMember($troop, $groupMember);
        $em->persist($troopMember);
        $em->flush();

        $request = $this->request->withAttribute('groupId', $group->id);
        $apiResponse = $this->endpoint->__invoke($request, new Response(), []);
        $response = $apiResponse->getBody()->__toString();
        assertJson($response);
        $result = json_decode($response, true);

        assertEquals($troop->id, $result['data'][$member->id]['unit']['raw_value']);
        assertEquals($troop->name, $result['data'][$member->id]['unit']['value']);
    }

    public function testPatrolRelation() {
        $em = $this->entityManager;
        $group = new Model\ScoutGroup();
        $em->persist($group);
        $member = new Model\Member();
        $em->persist($member);
        $groupMember = new Model\GroupMember($group, $member);
        $em->persist($groupMember);
        $troop = new Model\Troop($group);
        $em->persist($troop);
        $troopMember = new Model\TroopMember($troop, $groupMember);
        $em->persist($troopMember);
        $patrol = new Model\Patrol($troop);
        $em->persist($patrol);
        $patrolMember = new Model\PatrolMember($patrol, $groupMember);
        $em->persist($patrolMember);
        $em->flush();

        $request = $this->request->withAttribute('groupId', $group->id);
        $apiResponse = $this->endpoint->__invoke($request, new Response(), []);
        $response = $apiResponse->getBody()->__toString();
        assertJson($response);
        $result = json_decode($response, true);

        assertEquals($patrol->id, $result['data'][$member->id]['patrol']['raw_value']);
        assertEquals($patrol->name, $result['data'][$member->id]['patrol']['value']);
    }
}
