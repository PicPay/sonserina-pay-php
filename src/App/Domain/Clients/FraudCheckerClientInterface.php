<?php

declare(strict_types=1);

namespace App\Domain\Clients;

use App\Domain\Entities\Transaction;

interface FraudCheckerClientInterface
{
    public function connect(bool $return): bool;
    public function check(Transaction $transaction): bool;
}