<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateGroupTest extends GroupTestBase
{
    public function testUpdateGroup(): void
    {
        $payload = ['name' => 'New group name'];
        $carlosGroupId = $this->getCarlosGroupId();

        self::$carlos->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $carlosGroupId),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
        $this->assertEquals($carlosGroupId, $responseData['id']);
    }

    public function testUpdateAnotherGroup(): void
    {
        $payload = ['name' => 'New group name'];
        $carlosGroupId = $this->getCarlosGroupId();

        self::$duviel->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $carlosGroupId),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$duviel->getResponse();


        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}