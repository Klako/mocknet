<?php

namespace Scouterna\Mocknet;

use \Slim\Psr7\Request;
use Slim\Psr7\Response;

class Members extends ApiEndpoint
{
    protected function getResponse(Request $request, Response $response, $args): Response
    {
        $params = $request->getQueryParams();

        $returnObject = null;

        if (isset($params['waiting']) && $params['waiting']) {
            $returnObject = $this->getWaitingMembers();
        } else {
            $returnObject = $this->getMembers();
        }

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(\json_encode($returnObject));

        return $response;
    }

    private function getMembers()
    {
        $stmt = $this->db->query(
            <<<SQL
            SELECT * FROM v_memberlist
            WHERE `group` = {$this->db->quote($this->groupId)}
            SQL
        );

        $returnObject = new \stdClass;
        $returnObject->data = new \stdClass;

        while ($member = $stmt->fetch()) {
            $memberObj = new \stdClass;
            // Populate member info.

            self::addValue($memberObj, 'member_no', $member);
            self::addValue($memberObj, 'first_name', $member);
            self::addValue($memberObj, 'last_name', $member);
            self::addValue($memberObj, 'ssno', $member);
            self::addValue($memberObj, 'note', $member);
            self::addValue($memberObj, 'date_of_birth', $member);
            self::addValueRaw($memberObj, 'status', 'status_name', $member);
            self::addValue($memberObj, 'created_at', $member);
            self::addValue($memberObj, 'confirmed_at', $member);
            self::addValueRaw($memberObj, 'group', 'group_name', $member);
            self::addValueRaw($memberObj, 'unit', 'unit_name', $member);
            self::addValueRaw($memberObj, 'patrol', 'patrol_name', $member);
            self::addValueRaw($memberObj, 'sex', 'sex_name', $member);
            self::addValue($memberObj, 'address_1', $member);
            self::addValue($memberObj, 'postcode', $member);
            self::addValue($memberObj, 'town', $member);
            self::addValue($memberObj, 'country', $member);
            self::addValue($memberObj, 'email', $member);
            self::addValue($memberObj, 'contact_alt_email', $member);
            self::addValue($memberObj, 'contact_mobile_phone', $member);
            self::addValue($memberObj, 'contact_home_phone', $member);
            self::addValue($memberObj, 'contact_mothers_name', $member);
            self::addValue($memberObj, 'contact_email_mum', $member);
            self::addValue($memberObj, 'contact_mobile_mum', $member);
            self::addValue($memberObj, 'contact_telephone_mum', $member);
            self::addValue($memberObj, 'contact_fathers_name', $member);
            self::addValue($memberObj, 'contact_email_dad', $member);
            self::addValue($memberObj, 'contact_mobile_dad', $member);
            self::addValue($memberObj, 'contact_telephone_dad', $member);
            self::addValue($memberObj, 'contact_leader_interest', $member);

            // Initiate roles object
            $rolesObj = null;

            // Get all group roles of group and member
            $groupRoles = $this->db->query(
                <<<SQL
                SELECT * FROM v_grouproles
                WHERE `group` = {$this->db->quote($this->groupId)}
                AND member = {$this->db->quote($member['member_no'])}
                SQL
            )->fetchAll();

            // Make group roles objects
            if ($groupRoles) {
                $groupRolesObj = new \stdClass;
                $groupRoleIds = [];
                $groupRoleNames = [];
                foreach ($groupRoles as $role) {
                    if (!isset($groupRolesObj->{$role['group']})) {
                        $groupRolesObj->{$role['group']} = new \stdClass;
                    }
                    $groupRolesObj->{$role['group']}->{$role['role_id']} = (object) [
                        'role_id' => $role['role_id'],
                        'role_name' => $role['role_name']
                    ];
                    $groupRoleIds[] = $role['role_id'];
                    $groupRoleNames[] = $role['role_name'];
                }
                $rolesObj = new \stdClass;
                $rolesObj->group = $groupRolesObj;
                $memberObj->group_role = (object) [
                    'raw_value' => \implode(',', $groupRoleIds),
                    'value' => \implode(', ', $groupRoleNames)
                ];
            }

            // Get all troop roles of group and member
            $troopRoles = $this->db->query(
                <<<SQL
                SELECT * FROM v_trooproles
                WHERE `group` = {$this->db->quote($this->groupId)}
                AND member = {$this->db->quote($member['member_no'])}
                SQL
            )->fetchAll();

            // Make troop roles object
            if ($troopRoles) {
                $troopRolesObj = new \stdClass;
                $troopRoleIds = [];
                $troopRoleNames = [];
                foreach ($troopRoles as $role) {
                    if (!isset($troopRolesObj->{$role['troop']})) {
                        $troopRolesObj->{$role['troop']} = new \stdClass;
                    }
                    $troopRolesObj->{$role['troop']}->{$role['role_id']} = (object) [
                        'role_id' => $role['role_id'],
                        'role_name' => $role['role_name']
                    ];
                    $troopRoleIds[] = $role['role_id'];
                    $troopRoleNames[] = $role['role_name'];
                }
                if (!$rolesObj) {
                    $rolesObj = new \stdClass;
                }
                $rolesObj->troop = $troopRolesObj;
                $memberObj->unit_role = (object) [
                    'raw_value' => \implode(',', $troopRoleIds),
                    'value' => \implode(', ', $troopRoleNames)
                ];
            }

            // Get all patrol roles of group and member
            $patrolRoles = $this->db->query(
                <<<SQL
                SELECT * FROM v_patrolroles
                WHERE `group` = {$this->db->quote($this->groupId)}
                AND member = {$this->db->quote($member['member_no'])}
                SQL
            )->fetchAll();

            // Make patrol roles object
            if ($patrolRoles) {
                $patrolRolesObj = new \stdClass;
                foreach ($patrolRoles as $role) {
                    if (!isset($patrolRolesObj->{$role['patrol']})) {
                        $patrolRolesObj->{$role['patrol']} = new \stdClass;
                    }
                    $patrolRolesObj->{$role['patrol']}->{$role['role_id']} = (object) [
                        'role_id' => $role['role_id'],
                        'role_name' => $role['role_name']
                    ];
                }
                if (!$rolesObj) {
                    $rolesObj = new \stdClass;
                }
                $rolesObj->troop = $patrolRolesObj;
            }

            if ($rolesObj) {
                $memberObj->roles = (object) [
                    'value' => $rolesObj
                ];
            } else {
                $memberObj->roles = [];
            }

            $returnObject->data->{$member['member_no']} = $memberObj;
        }

        return $returnObject;
    }



    private function getWaitingMembers()
    {
        $stmt = $this->db->query(
            <<<SQL
            SELECT * FROM v_waitinglist
            WHERE `group` = {$this->db->quote($this->groupId)}
            SQL
        );

        $returnObject = new \stdClass;
        $returnObject->data = new \stdClass;

        while ($member = $stmt->fetch()) {
            $memberObj = new \stdClass;
            // Populate member info.
            self::addValue($memberObj, 'member_no', $member);
            self::addValue($memberObj, 'first_name', $member);
            self::addValue($memberObj, 'last_name', $member);
            self::addValue($memberObj, 'ssno', $member);
            self::addValue($memberObj, 'note', $member);
            self::addValue($memberObj, 'date_of_birth', $member);
            self::addValueRaw($memberObj, 'status', 'status_name', $member);
            self::addValue($memberObj, 'created_at', $member);
            self::addValue($memberObj, 'waiting_since', $member);
            self::addValueRaw($memberObj, 'group', 'group_name', $member);
            self::addValueRaw($memberObj, 'sex', 'sex_name', $member);
            self::addValue($memberObj, 'address_1', $member);
            self::addValue($memberObj, 'postcode', $member);
            self::addValue($memberObj, 'town', $member);
            self::addValue($memberObj, 'country', $member);
            self::addValue($memberObj, 'email', $member);
            self::addValue($memberObj, 'contact_alt_email', $member);
            self::addValue($memberObj, 'contact_mobile_phone', $member);
            self::addValue($memberObj, 'contact_home_phone', $member);
            self::addValue($memberObj, 'contact_mothers_name', $member);
            self::addValue($memberObj, 'contact_email_mum', $member);
            self::addValue($memberObj, 'contact_mobile_mum', $member);
            self::addValue($memberObj, 'contact_telephone_mum', $member);
            self::addValue($memberObj, 'contact_fathers_name', $member);
            self::addValue($memberObj, 'contact_email_dad', $member);
            self::addValue($memberObj, 'contact_mobile_dad', $member);
            self::addValue($memberObj, 'contact_telephone_dad', $member);
            self::addValue($memberObj, 'contact_leader_interest', $member);

            $returnObject->data->{$member['member_no']} = $memberObj;
        }

        return $returnObject;
    }

    private static function addValue($object, $name, &$dbRow)
    {
        if (!isset($dbRow[$name]) && $dbRow[$name] !== null) {
            return false;
        }
        $object->{$name} = (object) [
            'value' => strval($dbRow[$name])
        ];
        return true;
    }

    private static function addValueRaw($object, $rawName, $valueName, &$dbRow)
    {
        if (!isset($dbRow[$rawName]) && $dbRow[$rawName] !== null) {
            return false;
        }
        $object->{$rawName} = (object) [
            'raw_value' => strval($dbRow[$rawName]),
            'value' => strval($dbRow[$valueName])
        ];
        return true;
    }
}
