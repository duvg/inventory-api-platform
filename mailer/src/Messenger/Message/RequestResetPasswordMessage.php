<?php

namespace Mailer\Messenger\Message;

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

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getResetPasswoordToken(): string
    {
        return $this->resetPasswoordToken;
    }
}