<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadFileTest extends MovementTestBase
{
    public function testMovementUploadFile(): void
    {
        $file = new UploadedFile(
            __DIR__.'/../../../fixtures/images/ticket.png',
            'ticket.png'
        );

        self::$carlos->request(
            'POST',
            sprintf('%s/%s/upload_file', $this->endpoint, $this->getCarlosMovementId()),
            [],
            ['file' => $file]
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());

    }

    public function testUploadFileWithWrongInputName(): void
    {
        $file = new UploadedFile(
            __DIR__.'/../../../fixtures/images/ticket.png',
            'ticket.png'
        );

        self::$carlos->request(
            'POST',
            sprintf('%s/%s/upload_file', $this->endpoint, $this->getCarlosMovementId()),
            [],
            ['not-valit-input' => $file]
        );

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

}