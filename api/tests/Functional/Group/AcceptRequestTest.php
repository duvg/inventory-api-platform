<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use App\Exception\GroupRequest\GroupRequestNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

class AcceptRequestTest extends GroupTestBase
{
    public function testAcceptRequest(): void
    {
        $payload = [
            'userId' => $this->getDuvielId(),
            'token' => '2345678'
        ];


        self::$duviel->request(
            'PUT',
            \sprintf('%s/%s/accept_request', $this->endpoint, $this->getCarlosGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$duviel->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('The user has been added to the group', $responseData['message']);
    }

    public function testAcceptAnAlreadyAcceptedRequest(): void
    {
        $this->testAcceptRequest();

        $payload = [
            'userId' => $this->getDuvielId(),
            'token' => '2345678'
        ];


        self::$duviel->request(
            'PUT',
            \sprintf('%s/%s/accept_request', $this->endpoint, $this->getCarlosGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$duviel->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEquals(GroupRequestNotFoundException::class, $responseData['class']);


    }
}