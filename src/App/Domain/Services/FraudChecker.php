<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Factorys\FraudCheckers\FraudCheckerFactory;
use Exception;

class FraudChecker
{
    private $fraudCheckerIntegration;

    public function check(Transaction $transaction, array $sequenceClient = [1, 2]): bool
    { 
        return $this->checkClientConnect();
    }

    private function checkClientConnect()
    {
        $client = FraudCheckerFactory::getFraudCheckerOne();
        $this->getFraudChecker($client);
        
        return $this->getFraudCheckerConnect();
    }

    /**
     * @throws Exception
     */
    private function getFraudChecker($client)
    {
        try {
            $this->fraudCheckerIntegration = FraudCheckerFactory::getFraudCheckerIntegration($client);
        } catch (\Throwable $th) {
            throw new Exception("Failed to create client FraudChecker");
        }
    }

    /**
     * @throws Exception
     */
    private function getFraudCheckerConnect():bool
    {
        try {
            $connectSucces = $this->fraudCheckerIntegration->connect(true);
            return $connectSucces;
        } catch (\Throwable $th) {
            throw new Exception("Connection failure");
        }
    }
}
