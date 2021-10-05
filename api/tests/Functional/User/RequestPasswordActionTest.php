<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class RequestPasswordActionTest extends UserTestBase
{
    public function testRequestResetPasword(): void
    {
        $payload = [
            'email' => 'carlos@test.com'
        ];

        self::$carlos->request('POST', \sprintf('%s/request_reset_password', $this->endpoint), [],[],[], json_encode($payload));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testRequestResetPasswordForNonExistingEmail(): void
    {
        $payload = [
            'email' => 'carlos_non_exist@test.com'
        ];

        self::$carlos->request('POST', \sprintf('%s/request_reset_password', $this->endpoint), [],[],[], json_encode($payload));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}