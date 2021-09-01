<?php

declare(strict_types=1);

namespace App\Domain\Infra\FraudCheckers;

use App\Domain\Clients\FraudCheckerClientInterface;

class FraudCheckerOneAPI implements FraudCheckerClientInterface
{
    public function connect(bool $return):bool
    {
        return $return;
    }

    public function check(object $transaction):bool
    {
        return true; 
    }
}
