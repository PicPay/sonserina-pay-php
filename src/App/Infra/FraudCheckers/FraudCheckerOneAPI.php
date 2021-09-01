<?php

declare(strict_types=1);

namespace App\Infra\FraudCheckers;

use App\Domain\Clients\FraudCheckerClientInterface;

class FraudCheckerOneAPI implements FraudCheckerClientInterface
{
    public function connect(bool $params):bool
    {
        return $params;
    }

    public function check(object $transaction):bool
    {
        return true; 
    }
}
