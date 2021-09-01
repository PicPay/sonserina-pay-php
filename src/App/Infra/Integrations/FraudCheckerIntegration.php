<?php

declare(strict_types=1);

namespace App\Infra\Integrations;

use App\Domain\Entities\Transaction;
use App\Domain\Clients\FraudCheckerClientInterface;

class FraudCheckerIntegration
{
    private $checker;

    public function __construct(FraudCheckerClientInterface $checker)
    {
        $this->checker = $checker;
    }

    public function connect(bool $params): bool
    {
        return $this->checker->connect($params);
    }

    public function check(Transaction $transaction): bool
    {
        return $this->checker->check($transaction);
    }
}
