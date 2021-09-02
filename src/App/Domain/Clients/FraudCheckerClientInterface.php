<?php

declare(strict_types=1);

namespace App\Domain\Clients;
interface FraudCheckerClientInterface
{
    public function connect(bool $return): bool;
}