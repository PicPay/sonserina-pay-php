<?php

declare(strict_types=1);

namespace App\Domain\Traits;

trait Emailer
{

    /**
     * @var string
     */
    private string $email;

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

}
