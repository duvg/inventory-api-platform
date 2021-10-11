<?php

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class UserGroupTest extends UserTestBase
{
    public function testGetUserGroups(): void
    {
        self::$carlos->request(
            'GET',
            \sprintf('%s/%s/groups', $this->endpoint, $this->getCarlosId()),
            [],
            [],
            []
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(1, $responseData['hydra:member']);

    }

    public function testGetAnotherUserGroups(): void
    {
        self::$carlos->request(
            'GET',
            \sprintf('%s/%s/groups', $this->endpoint, $this->getDuvielId()),
            [],
            [],
            []
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can\'t retrieve another user groups', $responseData['message']);
    }
}