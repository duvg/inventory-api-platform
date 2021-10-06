<?php

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResendActivationEmailActionTest extends UserTestBase
{
    public function testResendActivationEmail(): void
    {
        $payload = ['email' => 'esther@test.com'];

        self::$esther->request('POST', sprintf('%s/resend_activation_email', $this->endpoint),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$esther->getResponse();
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testResendActivationEmailToActiveUser(): void
    {
        $payload = ['email' => 'carlos@test.com'];

        self::$carlos->request('POST', sprintf('%s/resend_activation_email', $this->endpoint),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_CONFLICT, $response->getStatusCode());
    }
}