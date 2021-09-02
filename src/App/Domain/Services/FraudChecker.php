<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Factorys\FraudCheckers\FraudCheckerFactory;
use App\Infra\Integrations\FraudCheckerIntegration;
use Exception;

class FraudChecker
{
    private $fraudCheckerIntegration;

    public function check(Transaction $transaction, array $sequenceClient = [1, 2]): bool
    { 
        $this->fraudCheckerIntegration = $this->getClientFraudChecker();
        $connect = $this->fraudCheckerIntegration->verifyConnect(true);
        
        if (!$connect) {
            return false;
        }

        return $this->fraudCheckerIntegration->isAuthorized($transaction);
    }

    /**
     * @return FraudCheckerIntegration
     * @throws Exception
     */
    private function getClientFraudChecker(): FraudCheckerIntegration
    {
        try {
            $client = FraudCheckerFactory::getFraudCheckerOne();
            return FraudCheckerFactory::getFraudCheckerIntegration($client);
        } catch (\Throwable $th) {
            throw new Exception("Failed to create client FraudChecker");
        }
    }
}
