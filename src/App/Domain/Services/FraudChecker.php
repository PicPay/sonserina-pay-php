<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Factorys\FraudCheckers\FraudCheckerFactory;
use Exception;

class FraudChecker
{
    public function check(Transaction $transaction, bool $orderReverse, array $simulateAuthorized): bool
    { 
        
        try {
            $fraudCheckers = FraudCheckerFactory::getFraudCheckers($orderReverse);
            foreach ($fraudCheckers as $key => $checker) {
                $connectResultSimulate = $simulateAuthorized[$key];
                $authorized = $checker->verifyAuthorized($transaction, $connectResultSimulate);
    
                if (!$authorized) {
                    continue;
                }
    
                return true;
            }
        } catch (\Throwable $th) {
            throw new Exception($th);
        }
    }
}
