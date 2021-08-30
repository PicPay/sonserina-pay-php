<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Entities\Transaction;

interface FraudCheckerClientInterface
{

    public function check(Transaction $transaction): void;
}
