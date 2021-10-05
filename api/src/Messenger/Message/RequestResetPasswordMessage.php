<?php

declare(strict_types=1);

namespace App\Messenger\Message;

class RequestResetPasswordMessage
{
    private string $id;
    private string $email;
    private string $resetPasswoordToken;

    public function __construct(string $id, string $email, string $resetPasswoordToken)
    {
        $this->id = $id;
        $this->email = $email;
        $this->resetPasswoordToken = $resetPasswoordToken;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getResetPasswoordToken(): string
    {
        return $this->resetPasswoordToken;
    }
}
