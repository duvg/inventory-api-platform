<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Entity\User;
use App\Exception\Password\PasswordException;
use App\Exception\User\UserAlreadyExistException;
use App\Messenger\Message\UserRegisteredMessage;
use App\Service\User\UserRegisterService;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Messenger\Envelope;

class UserRegisterServiceTest extends UserServiceTestBase
{
    private UserRegisterService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new UserRegisterService($this->userRepository, $this->encoderServioce, $this->messageBus);
    }

    public function testUserRegister(): void
    {
        $name ='testuser';
        $email = 'testuser@test.com';
        $password = '123456';

        $message = $this->getMockBuilder(UserRegisteredMessage::class)->disableOriginalConstructor()->getMock();

        $this->messageBus
            ->expects($this->exactly(1))
            ->method('dispatch')
            ->with($this->isType('object'), $this->isType('array'))
            ->willReturn(new Envelope($message));

        $user = $this->service->create($name, $email, $password);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($email, $user->getEmail());
    }

    public function testUserRegisterForInvalidPassword(): void
    {
        $name ='testuser';
        $email = 'testuser@test.com';
        $password = '123456';

        $this->encoderServioce
            ->expects($this->exactly(1))
            ->method('generateEncodedPassword')
            ->with($this->isType('object'), $this->isType('string'))
            ->willThrowException(new PasswordException());

        $this->expectException(PasswordException::class);

        $this->service->create($name, $email, $password);
    }

    public function testUserRegisterForAlreadyExistingUser(): void
    {
        $name ='testuser';
        $email = 'testuser@test.com';
        $password = '123456';

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('save')
            ->with($this->isType('object'))
            ->willThrowException(new ORMException());

        $this->expectException(UserAlreadyExistException::class);

        $this->service->create($name, $email, $password);
    }
}