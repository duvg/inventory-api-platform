<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetGroupTest extends GroupTestBase
{
    public function testGetGroup(): void
    {
        $carlosGroupId = $this->getCarlosGroupId();
        self::$carlos->request('GET', \sprintf('%s/%s', $this->endpoint, $carlosGroupId), [], [], []);

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($carlosGroupId, $responseData['id']);
        $this->assertEquals('Carlos Group', $responseData['name']);
    }

    public function testGetAnotherGroupData(): void
    {
        $carlosGroupId = $this->getCarlosGroupId();
        self::$duviel->request('GET', \sprintf('%s/%s', $this->endpoint, $carlosGroupId), [], [], []);

        $response = self::$duviel->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}