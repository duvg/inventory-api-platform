<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class SendRequestToUserTest extends GroupTestBase
{
    public function testSendRequestToUser(): void
    {
        $payload = ['email' => 'duviel@test.com'];

        self::$carlos->request(
            'PUT',
            \sprintf('%s/%s/send_request', $this->endpoint, $this->getCarlosGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('The request has been send', $responseData['message']);
    }

    public function testSendAnotherGroupRequestToUser(): void
    {
        $payload = ['email' => 'duviel@test.com'];

        self::$carlos->request(
            'PUT',
            \sprintf('%s/%s/send_request', $this->endpoint, $this->getDuvielGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You are not the owner of this group', $responseData['message']);
    }

    public function testSendRequestToUserAlreadyMember(): void
    {
        $payload = ['email' => 'carlos@test.com'];

        self::$carlos->request(
            'PUT',
            \sprintf('%s/%s/send_request', $this->endpoint, $this->getCarlosGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CONFLICT, $response->getStatusCode());
        $this->assertEquals('This user already member of the group', $responseData['message']);
    }


}