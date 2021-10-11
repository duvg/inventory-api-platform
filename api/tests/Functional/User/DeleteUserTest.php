<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserTest extends UserTestBase
{
    public function testDeleteUser(): void
    {
        self::$carlos->request(
            'DELETE',
            \sprintf('%s/%s', $this->endpoint, $this->getCarlosId()),
            [],
            [],
            []
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }
    public function testDeleteAnotherUser(): void
    {
        self::$carlos->request(
            'DELETE',
            \sprintf('%s/%s', $this->endpoint, $this->getDuvielId()),
            [],
            [],
            []
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}