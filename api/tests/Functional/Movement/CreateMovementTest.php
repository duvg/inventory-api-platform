<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use App\Tests\Functional\TestBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateMovementTest extends MovementTestBase
{
    public function testCreateMovement(): void
    {
        $ownerId = $this->getCarlosId();
        $categoryMovementId = $this->getCarlosExpenseCategoryMovementId();
        $payload = [
            'categoryMovement' => sprintf('/api/v1/category_movements/%s', $categoryMovementId),
            'owner' => sprintf('/api/v1/users/%s', $ownerId),
            'amount' => 5000
        ];

        self::$carlos->request(
            'POST',
            $this->endpoint,
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['amount'], $responseData['amount']);
    }

    public function testCreateMovementGroup(): void
    {
        $ownerId = $this->getCarlosId();
        $groupId = $this->getCarlosGroupId();
        $categoryMovementId = $this->getCarlosGroupExpenseCategoryMovementId();
        $payload = [
            'categoryMovement' => sprintf('/api/v1/category_movements/%s', $categoryMovementId),
            'owner' => sprintf('/api/v1/users/%s', $ownerId),
            'group' => sprintf('/api/v1/groups/%s', $groupId),
            'amount' => 5000
        ];

        self::$carlos->request(
            'POST',
            $this->endpoint,
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['amount'], $responseData['amount']);
    }

    public function testCreateMovementForAnotherUser(): void
    {
        $ownerId = $this->getCarlosId();;
        $categoryMovementId = $this->getCarlosGroupExpenseCategoryMovementId();
        $payload = [
            'categoryMovement' => sprintf('/api/v1/category_movements/%s', $categoryMovementId),
            'owner' => sprintf('/api/v1/users/%s', $ownerId),
            'amount' => 5000
        ];

        self::$duviel->request(
            'POST',
            $this->endpoint,
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$duviel->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can not create movement for another user', $responseData['message']);
    }

    public function testCreateMovementForAnotherGroup(): void
    {
        $ownerId = $this->getCarlosId();
        $groupId = $this->getDuvielGroupId();
        $categoryMovementId = $this->getCarlosGroupExpenseCategoryMovementId();
        $payload = [
            'categoryMovement' => sprintf('/api/v1/category_movements/%s', $categoryMovementId),
            'owner' => sprintf('/api/v1/users/%s', $ownerId),
            'group' => sprintf('/api/v1/groups/%s', $groupId),
            'amount' => 5000
        ];

        self::$carlos->request(
            'POST',
            $this->endpoint,
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can not create a movements for another group', $responseData['message']);
    }

    public function testCreateMovementWithAnotherCategoryGroup(): void
    {
        $ownerId = $this->getCarlosId();
        $groupId = $this->getCarlosGroupId();
        $categoryMovementId = $this->getDuvielGroupExpenseCategoryMovementId();
        $payload = [
            'categoryMovement' => sprintf('/api/v1/category_movements/%s', $categoryMovementId),
            'owner' => sprintf('/api/v1/users/%s', $ownerId),
            'group' => sprintf('/api/v1/groups/%s', $groupId),
            'amount' => 5000
        ];

        self::$carlos->request(
            'POST',
            $this->endpoint,
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can not use this category movement in this movement', $responseData['message']);
    }
}