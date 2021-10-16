<?php

namespace App\Tests\Functional\CategoryMovement;

use App\Entity\CategoryMovement;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateCategoryMovementTest extends CategoryMovementTestBase
{
    public function testCreateCategoryMovement(): void
    {
        $payload = [
            'name' => 'new category movement',
            'type' => CategoryMovement::EXPENSE,
            'owner' => \sprintf('/api/v1/users/%s', $this->getCarlosId())
        ];

        self::$carlos->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testCreateGroupCategoryMovement(): void
    {
        $payload = [
            'name' => 'new category movement',
            'type' => CategoryMovement::EXPENSE,
            'owner' => \sprintf('/api/v1/users/%s', $this->getCarlosId()),
            'group' => \sprintf('/api/v1/groups/%s', $this->getCarlosGroupId())
        ];

        self::$carlos->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testCreateCategoryMovementWithInvalidType(): void
    {
        $payload = [
            'name' => 'new category movement',
            'type' => 'invalid-type',
            'owner' => \sprintf('/api/v1/users/%s', $this->getCarlosId()),
        ];

        self::$carlos->request('POST', $this->endpoint, [],[],[], \json_encode($payload));

        $response = self::$carlos->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testCreateCategoryMovementForAnotherUser(): void
    {
        $payload = [
            'name' => 'new category movement',
            'type' => CategoryMovement::EXPENSE,
            'owner' => \sprintf('/api/v1/users/%s', $this->getDuvielId())
        ];

        self::$carlos->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can not create category movements for another user', $responseData['message']);
    }

    public function testCreateCategoryMovementForAnotherUserGroup(): void
    {
        $payload = [
            'name' => 'new category movement',
            'type' => CategoryMovement::EXPENSE,
            'owner' => \sprintf('/api/v1/users/%s', $this->getCarlosId()),
            'group' => \sprintf('/api/v1/groups/%s', $this->getDuvielGroupId())
        ];

        self::$carlos->request('POST', $this->endpoint, [],[],[], \json_encode($payload));

        $response = self::$carlos->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can not create category movements for another group', $responseData['message']);
    }
}