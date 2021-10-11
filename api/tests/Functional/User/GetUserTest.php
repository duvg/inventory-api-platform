<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserTest extends UserTestBase
{
    public function testGetUser(): void
    {
        $carlosId = $this->getCarlosId();
        self::$carlos->request('GET', \sprintf('%s/%s', $this->endpoint, $this->getCarlosId(), [], [], []));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($carlosId, $responseData['id']);
        $this->assertEquals('carlos@test.com', $responseData['email']);
    }
    public function testGetAnotherUserData(): void
    {
        self::$duviel->request('GET', \sprintf('%s/%s', $this->endpoint, $this->getCarlosId(), [], [], []));

        $response = self::$duviel->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}