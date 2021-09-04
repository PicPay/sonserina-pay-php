<?php

declare(strict_types=1);

namespace App\Domain\Traits;

trait EmailTrait
{

    /**
     * @var string
     */
    private string $email;

    /**
     * @param string $email
     */
    public function setEmail(string $email)
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
