<?php

namespace Scouterna\ScoutnetMock;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class GroupInfo extends ApiEndpoint
{
    protected function getResponse(Request $request, Response $response, $args): Response
    {
        $group = $this->db->query("SELECT * FROM groups WHERE id = {$this->db->quote($this->groupId)}")->fetch();
        $membercount = $this->db->query("SELECT COUNT(*) FROM groupmembers WHERE `group` = {$this->db->quote($this->groupId)}")->fetchColumn();
        $rolecount = $this->db->query(
            <<<SQL
            SELECT
                COUNT(*)
            FROM groupmemberroles gmr
            LEFT JOIN groupmembers gm ON gm.id = gmr.groupmember
            WHERE gm.`group` = {$this->db->quote($this->groupId)}
            GROUP BY gm.id
            SQL
        )->fetchColumn();
        $waitingcount = $this->db->query("SELECT COUNT(*) FROM groupwaiters WHERE `group` = {$this->db->quote($this->groupId)}")->fetchColumn();
        $group_email = $group['group_email'] ? 'true' : 'false';

        $leader = $this->db->query("SELECT first_name, last_name, email FROM members WHERE member_no = {$this->db->quote($group['leader'])}")->fetch();
        if ($leader) {
            $leaderInfo = <<<JSON
            {
                "name": "{$leader['first_name']} {$leader['last_name']}",
                "contactdetails": "{$leader['email']}"
            }
            JSON;
        } else {
            $leaderInfo = <<<JSON
            {
                "name" : "",
                "email": ""
            }
            JSON;
        }

        $body = <<<JSON
        {
            "Group": {
                "name": "{$group['name']}",
                "membercount": $membercount,
                "rolecount": $rolecount,
                "waitingcount": $waitingcount,
                "group_email": $group_email,
                "email": "{$group['email']}",
                "description": "{$group['description']}"
            },
            "Leader": $leaderInfo,
            "projects": "Not in use."
        }
        JSON;

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write($body);

        return $response;
    }
}
