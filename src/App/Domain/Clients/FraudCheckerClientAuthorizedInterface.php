<?php

declare(strict_types=1);

namespace App\Domain\Clients;

use App\Domain\Clients\FraudCheckerClientInterface;

interface FraudCheckerClientAuthorizedInterface extends FraudCheckerClientInterface
{
    public function isAuthorized(): bool;
}