<?php

namespace Scouterna\Mocknet\Api;

use Scouterna\Mocknet\Database\Model\CustomList;
use Scouterna\Mocknet\Database\Model\CustomListRule;
use Scouterna\Mocknet\Database\Model\ScoutGroup;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CustomLists extends ApiEndpoint
{
    protected function getResponse(Request $request, Response $response, $args): Response
    {
        $params = $request->getQueryParams();

        $listId = isset($params['list_id']) ? $params['list_id'] : false;
        $ruleId = isset($params['rule_id']) ? $params['rule_id'] : false;

        if ($listId && $ruleId) {
            return $this->getListRuleMembers($ruleId, $response);
        } elseif ($listId) {
            return $this->getListMembers($listId, $response);
        } else {
            return $this->getLists($response);
        }
    }

    private function getLists(Response $response): Response
    {
        /** @var ScoutGroup */
        $group = $this->entityManager->find(ScoutGroup::class, $this->groupId);
        $lists = $group->customLists;

        $returnList = [];

        foreach ($lists as $list) {
            $returnList[$list->id] = [
                'id' => $list->id,
                'title' => $list->title,
                'description' => $list->description,
                'list_email_key' => '',
                'aliases' => [],
                'owning_body_type' => 'group',
                'owning_body_id' => $this->groupId
            ];
            if ($list->rules->isEmpty()) {
                $returnList[$list->id]['rules'] = [];
            }
            $ruleList = [];
            foreach ($list->rules as $rule) {
                $ruleList[$rule->id] = [
                    'id' => $rule->id,
                    'title' => $rule->title,
                    'link' => ''
                ];
            }
            $returnList[$list->id]->rules = $ruleList;
        }
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(\json_encode($returnList));
        return $response;
    }

    private function getListMembers($listId, Response $response): Response
    {
        /** @var CustomList */
        $list = $this->entityManager->find(CustomList::class, $listId);
        $members = [];
        foreach ($list->rules as $rule) {
            foreach ($rule->members as $groupMember) {
                $member = $groupMember->member;
                if ($members[$member->id]) {
                    continue;
                }
                $members[$member->id] = [
                    'member_no' => ['value' => $member->id],
                    'email' => ['value' => $member->email],
                    'extra_emails' => ['value' => []],
                    'first_name' => ['value' => $member->first_name],
                    'last_name' => ['value' => $member->last_name],
                ];
            }
        }
        $returnObject = ['data' => $members];

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(\json_encode($returnObject));
        return $response;
    }

    private function getListRuleMembers($ruleId, Response $response): Response
    {
        /** @var CustomListRule */
        $rule = $this->entityManager->find(CustomListRule::class, $ruleId);
        $members = [];
        foreach ($rule->members as $groupMember) {
            $member = $groupMember->member;
            if ($members[$member->id]) {
                continue;
            }
            $members[$member->id] = [
                'member_no' => ['value' => $member->id],
                'email' => ['value' => $member->email],
                'extra_emails' => ['value' => []],
                'first_name' => ['value' => $member->first_name],
                'last_name' => ['value' => $member->last_name],
            ];
        }
        $returnObject = ['data' => $members];
        
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(\json_encode($returnObject));
        return $response;
    }
}
