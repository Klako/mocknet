<?php

namespace Scouterna\Mocknet\Api;

use Scouterna\Mocknet\Database\Model\ScoutGroup;
use Scouterna\Mocknet\Database\Model\Member;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class GroupInfo extends ApiEndpoint
{
    protected function getResponse(Request $request, Response $response, $args): Response
    {
        /** @var ScoutGroup */
        $group = $this->entityManager->find(ScoutGroup::class, $this->groupId);
        $membercount = $group->members->count();
        $rolecount = (function ($group) {
            /** @var ScoutGroup $group */
            $sum = 0;
            foreach ($group->members as $member) {
                if ($member->roles->count()) {
                    $sum++;
                }
            }
            return $sum;
        })($group);
        $waitingcount = $group->waiters->count();
        $group_email = $group->groupEmail ? 'true' : 'false';
        $leader = (function ($leader) {
            /** @var \Scouterna\Mocknet\Database\Model\GroupMember $leader */
            if ($leader) {
                $member = $leader->member;
                return <<<JSON
                    {
                        "name": "{$member->first_name} {$member->last_name}",
                        "contactdetails": "{$member->email}"
                    }
                    JSON;
            } else {
                return <<<JSON
                    {
                        "name": "",
                        "contactdetails": ""
                    }
                    JSON;
            }
        })($group->leader);

        $body = <<<JSON
        {
            "Group": {
                "name": "{$group->name}",
                "membercount": $membercount,
                "rolecount": $rolecount,
                "waitingcount": $waitingcount,
                "group_email": $group_email,
                "email": "{$group->email}",
                "description": "{$group->description}"
            },
            "Leader": $leader,
            "projects": "Not implemented."
        }
        JSON;

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write($body);

        return $response;
    }
}
