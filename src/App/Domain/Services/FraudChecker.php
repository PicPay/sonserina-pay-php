<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Factorys\FraudCheckers\FraudCheckerFactory;

class FraudChecker
{
    private $fraudCheckerIntegration;
    private $sequenceClient = [1, 2];

    public function check(Transaction $transaction, array $sequenceClient): bool
    {
        return $this->checkClientConnect();
    }

    private function checkClientConnect()
    {
        $client = FraudCheckerFactory::getFraudCheckerOne();
        $this->getFraudChecker($client);
        
        return $this->getFraudCheckerConnect();
    }

    private function getFraudChecker($client)
    {
        $this->fraudCheckerIntegration = FraudCheckerFactory::getFraudCheckerIntegration($client);
    }

    private function getFraudCheckerConnect()
    {
        $this->fraudCheckerIntegration->connect();
    }
}
