<?php

declare(strict_types=1);

namespace App\Infra\FraudCheckers;

use App\Domain\Clients\FraudCheckerClientAuthorizedInterface;
use App\Domain\Entities\Transaction;

class FraudCheckerOneAPI implements FraudCheckerClientAuthorizedInterface
{
    /**
     * @param bool $params
     * @return bool
    */
    public function connect(bool $params):bool
    {
        return $params;
    }

    /**
     * @param Transaction $transaction
     * @return bool
    */
    public function isAuthorized(Transaction $transaction): bool
    {
        return true;
    }
}
