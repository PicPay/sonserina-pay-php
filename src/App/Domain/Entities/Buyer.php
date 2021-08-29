<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Contracts\ReceptorEmailClientInterface;
use App\Domain\Traits\Emailer;

class Buyer implements ReceptorEmailClientInterface
{

    use Emailer;

    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $email;

}
