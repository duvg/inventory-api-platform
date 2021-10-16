<?php

namespace App\Tests\Functional\CategoryMovement;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetCategoryMovementTest extends CategoryMovementTestBase
{
    public function testGetCategoryMovementTest(): void
    {
        $carlosExpenseCategoryMovementId = $this->getCarlosExpenseCategoryMovementId();

        self::$carlos->request('GET', \sprintf('%s/%s', $this->endpoint, $carlosExpenseCategoryMovementId));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($carlosExpenseCategoryMovementId, $responseData['id']);
    }

    public function testGetGroupExpenseCategoryMovement(): void
    {
        $carlosGroupCategoryMovementId = $this->getCarlosGroupExpenseCategoryMovementId();

        self::$carlos->request('GET', \sprintf('%s/%s', $this->endpoint, $carlosGroupCategoryMovementId));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($carlosGroupCategoryMovementId, $responseData['id']);

    }

    public function testGetAnotherUserCategoryMovement(): void
    {
        $carlosExpenseCategoryMovementId = $this->getCarlosExpenseCategoryMovementId();

        self::$duviel->request('GET', \sprintf('%s/%s', $this->endpoint, $carlosExpenseCategoryMovementId));

        $response = self::$duviel->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testGetAnotherUserGroupExpenseCategoryMovement(): void
    {
        $carlosGroupCategoryMovementId = $this->getCarlosGroupExpenseCategoryMovementId();

        self::$duviel->request('GET', \sprintf('%s/%s', $this->endpoint, $carlosGroupCategoryMovementId));

        $response = self::$duviel->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}