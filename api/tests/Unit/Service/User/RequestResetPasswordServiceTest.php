<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Entity\User;
use App\Exception\User\UserNotFoundException;
use App\Messenger\Message\UserRegisteredMessage;
use App\Service\User\RequestResetPasswordService;
use Symfony\Component\Messenger\Envelope;

class RequestResetPasswordServiceTest extends UserServiceTestBase
{
    private RequestResetPasswordService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new RequestResetPasswordService($this->userRepository,$this->messageBus);
    }

    public function testRequestResetPasswordService(): void
    {
        $email = 'test@test.com';
        $user = new User('test', $email, '123456');

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('findOneByEmailOrFail')
            ->with($email)
            ->willReturn($user);

        $message = $this->getMockBuilder(UserRegisteredMessage::class)->disableOriginalConstructor()->getMock();

        $this->messageBus
            ->expects($this->exactly(1))
            ->method('dispatch')
            ->with($this->isType('object'), $this->isType('array'))
            ->willReturn(new Envelope($message));

        $this->service->send($email);

    }

    public function testRequestResetPasswordServiceForNonExistingUser(): void
    {
        $email = 'test@test.com';

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('findOneByEmailOrFail')
            ->with($email)
            ->willThrowException(new UserNotFoundException());

        $this->expectException(UserNotFoundException::class);

        $this->service->send($email);
    }
}