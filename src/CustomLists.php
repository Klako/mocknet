<?php

namespace Scouterna\ScoutnetMock;

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
        $lists = $this->db->query(
            <<<SQL
            SELECT
                *
            FROM customlists
            WHERE `group` = {$this->db->quote($this->groupId)}
            SQL
        )->fetchAll();

        if (empty($lists)) {
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write('[]');
            return $response;
        }

        $returnList = new \stdClass;
        foreach ($lists as $list) {
            $returnList->{$list['id']} = (object) [
                'id' => $list['id'],
                'title' => $list['title'],
                'description' => $list['description'],
                'list_email_key' => '',
                'aliases' => [],
                'owning_body_type' => 'group',
                'owning_body_id' => intval($this->groupId)
            ];

            $rules = $this->db->query(
                <<<SQL
                SELECT
                    *
                FROM customlistrules
                WHERE customlist = {$this->db->quote($list['id'])}
                SQL
            )->fetchAll();

            if (empty($rules)) {
                $returnList->{$list['id']}->rules = [];
                continue;
            }

            $ruleList = new \stdClass;
            foreach ($rules as $rule) {
                $ruleList->{$rule['id']} = (object) [
                    'id' => $rule['id'],
                    'title' => $rule['title'],
                    'link' => ''
                ];
            }
            $returnList->{$list['id']}->rules = $ruleList;
        }
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(\json_encode($returnList));

        return $response;
    }

    private function getListMembers($listId, Response $response): Response
    {
        $members = $this->db->query(
            <<<SQL
            SELECT
                m.member_no,
                m.email,
                m.first_name,
                m.last_name
            FROM members m
            LEFT JOIN customlistrulemembers clrm ON clrm.member = m.member_no
            LEFT JOIN customlistrules clr ON clr.id = clrm.customlistrule
            WHERE clr.customlist = {$this->db->quote($listId)}
            SQL
        )->fetchAll();
        $returnObject = new \stdClass;
        if (empty($members)) {
            $returnObject->data = [];
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(\json_encode($returnObject));
            return $response;
        }
        $returnObject->data = new \stdClass;
        foreach ($members as $member) {
            $returnObject->data->{$member['member_no']} = (object) [
                'member_no' => (object) [
                    'value' => $member['member_no']
                ],
                'email' => (object) [
                    'value' => $member['email']
                ],
                'extra_emails' => (object)[
                    'value' => []
                ],
                'first_name' => (object) [
                    'value' => $member['first_name']
                ],
                'last_name' => (object) [
                    'value' => $member['last_name']
                ],
            ];
        }
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(\json_encode($returnObject));
        return $response;
    }

    private function getListRuleMembers($ruleId, Response $response): Response
    {
        $members = $this->db->query(
            <<<SQL
            SELECT
                m.member_no,
                m.email,
                m.first_name,
                m.last_name
            FROM members m
            LEFT JOIN customlistrulemembers clrm ON clrm.member = m.member_no
            LEFT JOIN customlistrules clr ON clr.id = clrm.customlistrule
            WHERE clr.id = {$this->db->quote($ruleId)}
            SQL
        )->fetchAll();
        $returnObject = new \stdClass;
        if (empty($members)) {
            $returnObject->data = [];
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(\json_encode($returnObject));
            return $response;
        }
        $returnObject->data = new \stdClass;
        foreach ($members as $member) {
            $returnObject->data->{$member['member_no']} = (object) [
                'member_no' => (object) [
                    'value' => $member['member_no']
                ],
                'email' => (object) [
                    'value' => $member['email']
                ],
                'extra_emails' => (object)[
                    'value' => []
                ],
                'first_name' => (object) [
                    'value' => $member['first_name']
                ],
                'last_name' => (object) [
                    'value' => $member['last_name']
                ],
            ];
        }
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(\json_encode($returnObject));
        return $response;
    }
}
