<?php

declare(strict_types=1);

namespace App\Domain\Entities;

class Notification
{
    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $message;

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param  string  $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return  string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
