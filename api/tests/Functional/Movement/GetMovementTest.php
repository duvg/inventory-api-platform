<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetMovementTest extends MovementTestBase
{
    public function testGetMovement(): void
    {
        $movementId = $this->getCarlosMovementId();
        self::$carlos->request('GET', sprintf('%s/%s', $this->endpoint, $movementId));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($responseData['id'], $movementId);
    }

    public function testGetGroupMovement(): void
    {
        $movementId = $this->getCarlosGroupMovementId();
        self::$carlos->request('GET', sprintf('%s/%s', $this->endpoint, $movementId));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($responseData['id'], $movementId);
    }

    public function testGetMovementOfAnotherUser(): void
    {
        $movementId = $this->getDuvielMovementId();
        self::$carlos->request('GET', sprintf('%s/%s', $this->endpoint, $movementId));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testGetGroupMovementOfAnotherUser(): void
    {
        $movementId = $this->getDuvielGroupMovementId();
        self::$carlos->request('GET', sprintf('%s/%s', $this->endpoint, $movementId));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}