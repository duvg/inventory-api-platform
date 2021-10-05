<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginActionTest extends UserTestBase
{
    public function testLogin(): void
    {
        $payload = [
            'username' => 'carlos@test.com',
            'password' => 'password'
        ];

        self::$carlos->request('POST', sprintf('%s/login_check', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(JWTAuthenticationSuccessResponse::class, $response);
    }


    public function testLoginwithInvalidaCredentials(): void
    {
        $payload = [
            'username' => 'carlos1@est.com',
            'password' => 'password1'
        ];

        self::$carlos->request('POST', \sprintf('%s/login_check', $this->endpoint), [], [], [], json_encode($payload));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertInstanceOf(JWTAuthenticationFailureResponse::class, $response);


    }
}