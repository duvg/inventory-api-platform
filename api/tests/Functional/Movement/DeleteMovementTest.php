<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMovementTest extends MovementTestBase
{
    public function testDeleteMovement(): void
    {
        $movementId = $this->getCarlosMovementId();
        self::$carlos->request('DELETE', sprintf('%s/%s', $this->endpoint, $movementId));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteGroupMovement(): void
    {
        $movementId = $this->getCarlosGroupMovementId();
        self::$carlos->request('DELETE', sprintf('%s/%s', $this->endpoint, $movementId));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteMovementForAnotherUser(): void
    {
        $movementId = $this->getDuvielMovementId();
        self::$carlos->request('DELETE', sprintf('%s/%s', $this->endpoint, $movementId));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testDeleteMovementForAnotherGroupUser(): void
    {
        $movementId = $this->getDuvielGroupMovementId();
        self::$carlos->request('DELETE', sprintf('%s/%s', $this->endpoint, $movementId));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}