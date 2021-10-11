<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteGroupTest extends GroupTestBase
{
    public function testDeleteGroup(): void
    {
        $carlosGroupId = $this->getCarlosGroupId();

        self::$carlos->request('DELETE', \sprintf('%s/%s', $this->endpoint, $carlosGroupId), [], [], []);

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteAnotherGroup(): void
    {
        $carlosGroupId = $this->getCarlosGroupId();

        self::$duviel->request('DELETE', \sprintf('%s/%s', $this->endpoint, $carlosGroupId), [], [], []);

        $response = self::$duviel->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}