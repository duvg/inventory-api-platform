<?php

declare(strict_types=1);

namespace App\Api\Action\User;

use App\Tests\Functional\User\UserTestBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChangePasswordActionTest extends UserTestBase
{
    public function testChangePasswordActionTest(): void
    {
        $payload = [
            'oldPassword' => 'password',
            'newPassword' => 'new-password'
        ];

        self::$carlos->request(
            'PUT',
           sprintf('%s/%s/change_password', $this->endpoint, $this->getCarlosId()),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testChangePasswordWithInvalidOldPassword(): void
    {
        $payload = [
            'oldPassword' => 'password-bad',
            'newPassword' => 'new-password'
        ];

        self::$carlos->request(
            'PUT',
            sprintf('%s/%s/change_password', $this->endpoint, $this->getCarlosId()),
            [],
            [],
            [],
            json_encode($payload)
        );

        $response = self::$carlos->getResponse();
        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}