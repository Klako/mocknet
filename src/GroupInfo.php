<?php

namespace Scouterna\Mocknet;

use Scouterna\Mocknet\Database\Model\Group;
use Scouterna\Mocknet\Database\Model\Member;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class GroupInfo extends ApiEndpoint
{
    protected function getResponse(Request $request, Response $response, $args): Response
    {
        /** @var Group */
        $group = $this->entityManager->find(Group::class, 1);
        $membercount = $group->members->count();
        $rolecount = (function ($group) {
            /** @var Group $group */
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
            /** @var Member $leader */
            if ($leader) {
                return <<<JSON
                {
                    "name": "{$leader->first_name} {$leader->last_name}",
                    "contactdetails": "{$leader->email}"
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
        })($group->leader->member);

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
            "Leader": $leader,
            "projects": "Not implemented."
        }
        JSON;

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write($body);

        return $response;
    }
}
