<?php

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserCategoryMovementTest extends UserTestBase
{
    public function testGetUserCategoryMovementTest(): void
    {
        self::$carlos->request('GET', \sprintf('%s/%s/category_movements', $this->endpoint, $this->getCarlosId()));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(2, $responseData['hydra:member']);
    }

    public function testGetAnotherUserMovementTest(): void
    {
        self::$duviel->request('GET', \sprintf('%s/%s/category_movements', $this->endpoint, $this->getCarlosId()));

        $response = self::$duviel->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(0, $responseData['hydra:member']);
    }

}