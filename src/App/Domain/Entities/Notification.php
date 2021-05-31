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
}
