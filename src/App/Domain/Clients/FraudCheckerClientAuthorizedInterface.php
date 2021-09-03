<?php

declare(strict_types=1);

namespace App\Domain\Clients;

use App\Domain\Clients\FraudCheckerClientInterface;
use App\Domain\Entities\Transaction;

interface FraudCheckerClientAuthorizedInterface extends FraudCheckerClientInterface
{
    public function isAuthorized(Transaction $transaction, array $simulateAuthorized): bool;
}
