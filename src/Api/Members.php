<?php

namespace Scouterna\Mocknet\Api;

use Scouterna\Mocknet\Database\Model\ScoutGroup;
use Scouterna\Mocknet\Database\Model\Member;
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
        /** @var ScoutGroup */
        $group = $this->entityManager->find(ScoutGroup::class, $this->groupId);

        $returnObject = [];

        foreach ($group->members as $groupMember) {
            $member = $groupMember->member;
            $memberObj = [];

            self::addMemberValues($memberObj, $member);
            self::addValue($memberObj, 'confirmed_at', $groupMember->confirmedAt->format('Y-m-d'));
            self::addValue($memberObj, 'contact_leader_interest', $groupMember->contact_leader_interest);
            self::addValueRaw($memberObj, 'group', $group->id, $group->name);
            if ($troop = $groupMember->troop) {
                self::addValueRaw($memberObj, 'unit', $troop->id, $troop->name);
            }
            $troopRoleIds = [];
            $troopRoleNames = [];
            foreach ($groupMember->troopRoles as $troopRole) {
                $troopRoleIds[] = $troopRole->role->id;
                $troopRoleNames[] = $troopRole->role->name;
            }
            self::addValueRaw($memberObj, 'unit_role', join(',', $troopRoleIds), join(', ', $troopRoleNames));
            
            if ($patrol = $groupMember->patrol) {
                self::addValueRaw($memberObj, 'patrol', $patrol->id, $patrol->name);
            }

            $rolesObj = [];
            foreach ($groupMember->roles as $role) {
                $rolesObj['value']['group'][$group->id][$role->id] = [
                    'role_id' => $role->id,
                    'role_key' => $role->key,
                    'role_name' => $role->name
                ];
            }
            foreach ($groupMember->troopRoles as $troopRole) {
                $role = $troopRole->role;
                $rolesObj['value']['troop'][$troopRole->troop->id][$role->id] = [
                    'role_id' => $role->id,
                    'role_key' => $role->key,
                    'role_name' => $role->name
                ];
            }
            foreach ($groupMember->patrolRoles as $patrolRole) {
                $role = $patrolRole->role;
                $rolesObj['value']['patrol'][$patrolRole->patrol->id][$role->id] = [
                    'role_id' => $role->id,
                    'role_id' => $role->key,
                    'role_name' => $role->name
                ];
            }

            if ($rolesObj) {
                $memberObj['roles'] = $rolesObj;
            }

            $returnObject['data'][$member->id] = $memberObj;
        }

        $returnObject['labels'] = self::memberlistLabels();

        return $returnObject;
    }



    private function getWaitingMembers()
    {
        /** @var ScoutGroup */
        $group = $this->entityManager->find(ScoutGroup::class, $this->groupId);

        $returnObject = [];

        foreach ($group->waiters as $groupWaiter) {
            $member = $groupWaiter->member;
            $memberObj = [];

            self::addMemberValues($memberObj, $member);
            self::addValue($memberObj, 'waiting_since', $groupWaiter->waitingSince->format('Y-m-d'));
            self::addValue($memberObj, 'contact_leader_interest', $groupWaiter->contact_leader_interest);
            self::addValueRaw($memberObj, 'group', $group->id, $group->name);

            $returnObject['data'][$member->id] = $memberObj;
        }

        $returnObject['labels'] = self::waitinglistLabels();

        return $returnObject;
    }

    /**
     * @param array $object 
     * @param \Scouterna\Mocknet\Database\Model\Member $member 
     * @return void 
     */
    private static function addMemberValues(&$object, $member)
    {
        self::addValue($object, 'member_no', $member->id);
        self::addValue($object, 'first_name', $member->first_name);
        self::addValue($object, 'last_name', $member->last_name);
        self::addValue($object, 'ssno', $member->ssno);
        self::addValue($object, 'note', $member->note);
        self::addValue($object, 'date_of_birth', $member->date_of_birth->format('Y-m-d'));
        self::addValue($object, 'created_at', $member->created_at->format('Y-m-d'));
        $object['sex'] = Member::SEX_ARRAY[$member->sex];
        $object['status'] = Member::STATUS_ARRAY[$member->status];
        self::addValue($object, 'address_1', $member->address_1);
        self::addValue($object, 'postcode', $member->postcode);
        self::addValue($object, 'town', $member->town);
        self::addValue($object, 'country', $member->country);
        self::addValue($object, 'email', $member->email);
        self::addValue($object, 'contact_alt_email', $member->contact_alt_email);
        self::addValue($object, 'contact_mobile_phone', $member->contact_mobile_phone);
        self::addValue($object, 'contact_home_phone', $member->contact_home_phone);
        self::addValue($object, 'contact_mothers_name', $member->contact_mothers_name);
        self::addValue($object, 'contact_email_mum', $member->contact_email_mum);
        self::addValue($object, 'contact_mobile_mum', $member->contact_mobile_mum);
        self::addValue($object, 'contact_telephone_mum', $member->contact_telephone_mum);
        self::addValue($object, 'contact_fathers_name', $member->contact_fathers_name);
        self::addValue($object, 'contact_email_dad', $member->contact_email_dad);
        self::addValue($object, 'contact_mobile_dad', $member->contact_mobile_dad);
        self::addValue($object, 'contact_telephone_dad', $member->contact_telephone_dad);
    }

    private static function addValue(&$object, $name, $value)
    {
        if ($value) {
            $object[$name] = ['value' => strval($value)];
        }
    }

    private static function addValueRaw(&$object, $name, $rawValue, $value)
    {
        if ($rawValue) {
            $object[$name] = [
                'raw_value' => strval($rawValue),
                'value' => strval($value)
            ];
        }
    }

    private static function memberlistLabels()
    {
        return [
            "member_no" => "Medlemsnr.",
            "first_name" => "Förnamn",
            "last_name" => "Efternamn",
            "ssno" => "Personnummer",
            "nickname" => "Smeknamn",
            "note" => "Noteringar",
            "date_of_birth" => "Födelsedatum=>",
            "status" => "Status",
            "created_at" => "Registrerad Scouterna",
            "confirmed_at" => "Startdatum Kår",
            "group" => "Kår",
            "unit" => "Avdelning",
            "patrol" => "Patrull",
            "unit_role" => "Avdelningsroll",
            "group_role" => "Kårfunktion",
            "sex" => "Kön",
            "address_co" => "c\/o",
            "address_1" => "Adress",
            "address_2" => "Adress, rad 2",
            "address_3" => "Adress, rad 3",
            "postcode" => "Postnummer",
            "town" => "Postort",
            "country" => "Land",
            "email" => "Primär e-postadress",
            "contact_alt_email" => "Alternativ e-post",
            "contact_mobile_phone" => "Mobiltelefon",
            "contact_home_phone" => "Hemtelefon",
            "contact_mothers_name" => "Anhörig 1 namn",
            "contact_email_mum" => "Anhörig 1 e-post",
            "contact_mobile_mum" => "Anhörig 1 mobiltelefon",
            "contact_telephone_mum" => "Anhörig 1 hemtelefon",
            "contact_fathers_name" => "Anhörig 2 namn",
            "contact_email_dad" => "Anhörig 2 e-post",
            "contact_mobile_dad" => "Anhörig 2 mobiltelefon",
            "contact_telephone_dad" => "Anhörig 2 hemtelefon",
            "contact_work_phone" => "Arbetstelefon",
            "contact_email" => "E-post",
            "contact_leader_interest" => "Jag kan hjälpa till!",
            "prev_term" => "Höst 2021",
            "prev_term_due_date" => "Medlemsavgift förfallodatum",
            "current_term" => "Vår 2022",
            "current_term_due_date" => "Medlemsavgift förfallodatum",
            "kid" => "Kid",
            "roles" => "Roller",
            "avatar_updated" => "Bild (Senast uppdaterad datum)",
            "avatar_url" => "Bild (URL)"
        ];
    }

    private static function waitinglistLabels()
    {
        return [
            "member_no" => "Medlemsnr.",
            "first_name" => "Förnamn",
            "last_name" => "Efternamn",
            "ssno" => "Personnummer",
            "note" => "Noteringar",
            "date_of_birth" => "Födelsedatum=>",
            "status" => "Status",
            "created_at" => "Registrerad Scouterna",
            "confirmed_at" => "Startdatum Kår",
            "group" => "Kår",
            "waiting_since" => "Ködatum",
            "sex" => "Kön",
            "address_co" => "c\/o",
            "address_1" => "Adress",
            "address_2" => "Adress, rad 2",
            "address_3" => "Adress, rad 3",
            "postcode" => "Postnummer",
            "town" => "Postort",
            "country" => "Land",
            "email" => "Primär e-postadress",
            "contact_alt_email" => "Alternativ e-post",
            "contact_mobile_phone" => "Mobiltelefon",
            "contact_home_phone" => "Hemtelefon",
            "contact_mothers_name" => "Anhörig 1 namn",
            "contact_email_mum" => "Anhörig 1 e-post",
            "contact_mobile_mum" => "Anhörig 1 mobiltelefon",
            "contact_telephone_mum" => "Anhörig 1 hemtelefon",
            "contact_fathers_name" => "Anhörig 2 namn",
            "contact_email_dad" => "Anhörig 2 e-post",
            "contact_mobile_dad" => "Anhörig 2 mobiltelefon",
            "contact_telephone_dad" => "Anhörig 2 hemtelefon",
            "contact_leader_interest" => "Jag kan hjälpa till!",
        ];
    }
}
