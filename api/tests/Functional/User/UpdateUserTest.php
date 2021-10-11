<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateUserTest extends UserTestBase
{
    public function testUpdateUser(): void
    {
        $payload = ['name' => 'new name'];

        self::$carlos->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getCarlosId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testUpdateAnotherUser(): void
    {
        $payload = ['name' => 'new name'];

        self::$carlos->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getDuvielId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}