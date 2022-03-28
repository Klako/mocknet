<?php

namespace Scouterna\Mocknet\Database;

use Scouterna\Mocknet\Database\ManagerFactory;
use Scouterna\Mocknet\Database\Model;
use Scouterna\Mocknet\Util\Helper;

class DbGenerator
{
    /** @var string[]|\Doctrine\DBAL\Connection */
    private $connection;

    /**
     * @param string[]|\Doctrine\DBAL\Connection $connection 
     * @return void 
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function generateDb($groupId = 1)
    {
        $factory = new ManagerFactory();
        $factory->setConnection($this->connection);
        $entityManager = $factory->makeManager();

        $faker = Helper::getFaker();
        $group = new Model\ScoutGroup();
        $group->id = $groupId;
        $entityManager->persist($group);
        foreach (\range(1, 100) as $m) {
            $member = new Model\Member();
            $entityManager->persist($member);
            $groupMember = new Model\GroupMember($group, $member);
            $entityManager->persist($groupMember);
        }
        $this->createTroops($entityManager, $group);

        return $entityManager;
    }

    /**
     * Generates troops for the given group
     * @param \Doctrine\ORM\EntityManager $entityManager 
     * @param Model\ScoutGroup $group
     * @return void 
     */
    private function createTroops($entityManager, $group)
    {
        $troopCount = 10;
        /** @var Model\GroupMember[][] */
        $groupMembers = $group->members;
        $troopDivisions = $this->group($group->members->toArray(), $troopCount, 10);
        foreach ($troopDivisions as $troopDivision) {
            $troop = new Model\Troop($group);
            $entityManager->persist($troop);
            foreach ($troopDivision as $groupMember) {
                $troopMember = new Model\TroopMemberRole($troop, $groupMember);
                $entityManager->persist($troopMember);
            }
            $this->createPatrols($entityManager, $troop);
        }
    }

    private function createPatrols($entityManager, $troop)
    {
        /** @var Model\TroopMemberRole[][] */
        $patrolDivisions = $this->group($troop->members->toArray(), 4, 2);
        foreach ($patrolDivisions as $patrolDivision) {
            $patrol = new Model\Patrol($troop);
            $entityManager->persist($patrol);
            foreach ($patrolDivision as $troopMember) {
                $patrolMember = new Model\PatrolMemberRole($patrol, $troopMember->member);
                $entityManager->persist($patrolMember);
            }
        }
    }

    /**
     * Groups the the array evenly between an amount of groups until a max
     * has been reached
     * @param array $array The array to be divided
     * @param int $numberOfGroups The number of groups
     * @param int $perGroup The max amount of elements per group
     * @return mixed[][]
     */
    private function group(array $array, int $numberOfGroups, int $perGroup)
    {
        $faker = Helper::getFaker();
        $faker->shuffleArray($array);

        $returnArray = [];
        $group = 0;
        $totalPerGroup = 0;
        foreach ($array as $element) {
            if ($totalPerGroup == $perGroup) {
                break;
            }
            $returnArray[$group][] = $element;
            if (++$group == $numberOfGroups) {
                $group = 0;
                $totalPerGroup++;
            }
        }
        return $returnArray;
    }
}
