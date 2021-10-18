<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadAvatarTest extends UserTestBase
{
    public function testUploadAvatar(): void
    {
        $avatar = new UploadedFile(
            __DIR__.'/../../../fixtures/images/idea.png',
            'idea.png'
        );

        self::$carlos->request(
            'POST',
            \sprintf('%s/%s/avatar', $this->endpoint, $this->getCarlosId()),
            [],
            ['avatar' => $avatar]
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
    }

    public function testUploadAvatarWithInvalidInputName(): void
    {
        $avatar = new UploadedFile(
            __DIR__.'/../../../fixtures/images/idea.png',
            'idea.png'
        );

        self::$carlos->request(
            'POST',
            \sprintf('%s/%s/avatar', $this->endpoint, $this->getCarlosId()),
            [],
            ['non-valid-input' => $avatar]
        );

        $response = self::$carlos->getResponse();


        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}