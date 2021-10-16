<?php

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetGroupCategoryMovementTest extends GroupTestBase
{
    public function testGetGroupCategoryMovements(): void
    {
        self::$carlos->request('GET', \sprintf('%s/%s/category_movements', $this->endpoint, $this->getCarlosGroupId()));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(2, $responseData['hydra:member']);

    }

    public function testGetAnotherUserGroupCategoryMovements(): void
    {
        self::$duviel->request('GET', \sprintf('%s/%s/category_movements', $this->endpoint, $this->getCarlosGroupId()));

        $response = self::$duviel->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(0, $responseData['hydra:member']);
    }
}