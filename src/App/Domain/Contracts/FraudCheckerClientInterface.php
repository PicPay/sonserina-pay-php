<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

interface FraudCheckerClientInterface
{
    public function connect(bool $return): bool;
}
