<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Factorys\FraudCheckers\FraudCheckerFactory;
use Exception;

class FraudChecker
{
    public function check(Transaction $transaction, bool $orderReverse, array $simulateConnect): bool
    { 
        
        try {
            $fraudCheckers = FraudCheckerFactory::getFraudCheckers($orderReverse);
            
            foreach ($fraudCheckers as $key => $checker) {
                $connectResultSimulate = $simulateConnect[$key]['connect'];
                $connect = $checker->verifyConnect($connectResultSimulate);
            
                if (!$connect) {
                    continue;
                }
    
                $authorized = $checker->isAuthorized($transaction);
    
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
