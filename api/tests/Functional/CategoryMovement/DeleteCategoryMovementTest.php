<?php

namespace App\Tests\Functional\CategoryMovement;

use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteCategoryMovementTest extends CategoryMovementTestBase
{
    public function testDeleteCategoryMovement(): void
    {
        self::$carlos->request(
            'DELETE',
            \sprintf('%s/%s', $this->endpoint, $this->getCarlosExpenseCategoryMovementId())
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteGroupCategoryMovement(): void
    {
        self::$carlos->request(
            'DELETE',
            \sprintf('%s/%s', $this->endpoint, $this->getCarlosGroupExpenseCategoryMovementId())
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteCategoryMovementOfAnotherUser(): void
    {
        self::$carlos->request(
            'DELETE',
            \sprintf('%s/%s', $this->endpoint, $this->getDuvielExpenseCategoryMovementId())
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testDeleteCategoryMovementOfAnotherUserGroup(): void
    {
        self::$carlos->request(
            'DELETE',
            \sprintf('%s/%s', $this->endpoint, $this->getDuvielGroupExpenseCategoryMovementId())
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}