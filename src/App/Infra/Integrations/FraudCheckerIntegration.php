<?php

declare(strict_types=1);

namespace App\Domain\Infra\Integrations;

use App\Domain\Entities\Transaction;
use App\Domain\Clients\FraudCheckerClientInterface;

class FraudCheckerIntegration
{
    private $checkerConnection;

    public function __construct(FraudCheckerClientInterface $checkerConnection)
    {
        $this->checkerConnection = $checkerConnection;
    }

    public function connect(bool $return): bool
    {
        return $this->checkerConnection->connect(true);
    }

    public function check(Transaction $transaction): bool
    {
        return $this->checkerConnection->check($transaction);
    }
}
