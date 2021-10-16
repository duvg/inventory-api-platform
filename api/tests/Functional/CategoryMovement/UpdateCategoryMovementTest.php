<?php

namespace App\Tests\Functional\CategoryMovement;

use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateCategoryMovementTest extends CategoryMovementTestBase
{
    public function testUpdateCategoryMovementTest(): void
    {
        $payload = ['name' => 'new name'];
        $categoryMovementId = $this->getCarlosExpenseCategoryMovementId();

        self::$carlos->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $categoryMovementId),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($categoryMovementId, $responseData['id']);
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testUpdateGroupCategoryMovement(): void
    {
        $payload = ['name' => 'new name'];
        $categoryMovementId = $this->getCarlosGroupExpenseCategoryMovementId();

        self::$carlos->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $categoryMovementId),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($categoryMovementId, $responseData['id']);

    }

    public function testUpdateCategoryMovementAnotherUser(): void
    {
        $payload = ['name' => 'new name'];
        $categoryMovementId = $this->getCarlosExpenseCategoryMovementId();

        self::$duviel->request('PUT', \sprintf('%s/%s', $this->endpoint, $categoryMovementId),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$duviel->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testUpdateGroupCategoryMovementAnotherUser(): void
    {
        $payload = ['name' => 'new name'];
        $categoryMovementId = $this->getDuvielGroupExpenseCategoryMovementId();

        self::$carlos->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $categoryMovementId),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());

    }
}