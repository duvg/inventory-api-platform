<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateMovementTest extends MovementTestBase
{
    public function testUpdateMovement(): void
    {
        $movement = $this->getCarlosMovementId();
        $categoryMovementId = $this->getCarlosExpenseCategoryMovementId();
        $payload = [
            'categoryMovement' => sprintf('/api/v1/category_movements/%s',$categoryMovementId),
            'amount' => 4000
        ];

        self::$carlos->request(
            'PUT',
            sprintf('%s/%s', $this->endpoint, $movement),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($payload['amount'], $responseData['amount']);
    }

    public function testUpdateMovementGroup(): void
    {
        $movement = $this->getCarlosGroupMovementId();
        $categoryMovementId = $this->getCarlosGroupExpenseCategoryMovementId();
        $payload = [
            'categoryMovement' => sprintf('/api/v1/category_movements/%s',$categoryMovementId),
            'amount' => 4000
        ];

        self::$carlos->request(
            'PUT',
            sprintf('%s/%s', $this->endpoint, $movement),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($payload['amount'], $responseData['amount']);
    }

    public function testUpdateMovementForAnotherUser(): void
    {
        $movement = $this->getCarlosMovementId();
        $categoryMovementId = $this->getCarlosExpenseCategoryMovementId();
        $payload = [
            'categoryMovement' => sprintf('/api/v1/category_movements/%s',$categoryMovementId),
            'amount' => 4000
        ];

        self::$duviel->request(
            'PUT',
            sprintf('%s/%s', $this->endpoint, $movement),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$duviel->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testUpdateMovementForAnotherUserGroup(): void
    {
        $movement = $this->getCarlosGroupMovementId();
        $categoryMovementId = $this->getCarlosGroupExpenseCategoryMovementId();
        $payload = [
            'categoryMovement' => sprintf('/api/v1/category_movements/%s',$categoryMovementId),
            'amount' => 4000
        ];

        self::$duviel->request(
            'PUT',
            sprintf('%s/%s', $this->endpoint, $movement),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$duviel->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}