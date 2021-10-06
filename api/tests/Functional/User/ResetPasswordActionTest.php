<?php

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResetPasswordActionTest extends UserTestBase
{
    public function testResetPassword(): void
    {
        $carlosId = $this->getCarlosId();

        $payload = [
            "resetPasswordToken" => "123456",
            "password" => 'new-password'
        ];

        self::$carlos->request('PUT', sprintf('%s/%s/reset_password', $this->endpoint, $carlosId),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($carlosId, $responseData['id']);

    }
}