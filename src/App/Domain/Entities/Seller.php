<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Traits\EmailTrait;

class Seller
{
    use EmailTrait;

    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $name;
}
