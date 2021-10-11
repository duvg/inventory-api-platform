<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class CreateGroupTest extends GroupTestBase
{
    public function testCreateGroup(): void
    {
        $payload = [
            'name' => 'new group',
            'owner' => \sprintf('/api/v1/users/%s', $this->getCarlosId())
        ];

        self::$carlos->request(
            'POST',
            \sprintf($this->endpoint),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }


    public function testCreateGroupForAnotherUser(): void
    {
        $payload = [
            'name' => 'new group',
            'owner' => \sprintf('/api/v1/users/%s', $this->getDuvielId())
        ];

        self::$carlos->request(
            'POST',
            \sprintf($this->endpoint),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You cannot create groups for another user', $responseData['message']);
    }
}