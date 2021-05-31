<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;

class FraudChecker
{
    public function check(Transaction $transaction): bool
    {
        return false;
    }
}
