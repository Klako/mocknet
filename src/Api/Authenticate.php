<?php

namespace Scouterna\Mocknet\Api;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Scouterna\Mocknet\Database\Model;

class Authenticate extends ApiEndpoint
{
    protected function getResponse(Request $request, Response $response, $args): Response {
        $response = $response->withHeader('Content-Type', 'application/json');

        $params = $request->getQueryParams();
        $username = $params['username'];
        $password = $params['password'];

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('m')
            ->from(Model\Member::class, 'm')
            ->where($qb->expr()->andX(
                ':username IN (m.id, m.ssno, m.email)',
                $qb->expr()->eq('m.password', ':password')
            ));
        $qb->setParameter('username', "$username");
        $qb->setParameter('password', $password);
        $query = $qb->getQuery();
        /** @var Model\Member[] */
        $result = $query->getResult();

        if (empty($result)) {
            $response->getBody()->write(<<<JSON
                {
                    "err": "Incorrect login: Invalid username or password"
                }
            JSON);
            return $response;
        }

        $member = $result[0];
        $response->getBody()->write(<<<JSON
            {
                "token": "{$member->jwt_token}",
                "member": {
                    "member_no": {$member->id},
                    "first_name": "{$member->first_name}",
                    "last_name": "{$member->last_name}",
                    "email": "{$member->email}"
                }
            }
        JSON);
        
        return $response;
    }
}