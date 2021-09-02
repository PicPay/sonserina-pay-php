<?php

declare(strict_types=1);

namespace App\Infra\FraudCheckers;

use App\Domain\Clients\FraudCheckerClientAuthorizedInterface;
use App\Domain\Entities\Transaction;

class FraudCheckerOneAPI implements FraudCheckerClientAuthorizedInterface
{
    public function connect(bool $params):bool
    {
        return $params;
    }

    public function check(Transaction $transaction):bool
    {
        return true; 
    }

    public function isAuthorized(): bool
    {
        return true;
    }
}
