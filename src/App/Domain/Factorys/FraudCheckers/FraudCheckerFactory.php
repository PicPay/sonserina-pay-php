<?php

declare(strict_types=1);

namespace App\Domain\Factorys\FraudCheckers;

use App\Integrations\FraudCheckerIntegration;
use Exception;

class FraudCheckerFactory
{
     
     protected const FAILURE_CREATE_CLIENT = "Failed to create client FraudChecker";
     
     /**
     * @var array 
     */
     protected const CLIENTS_CHECKERS = [
          \App\Infra\FraudCheckers\FraudCheckerOneAPI::class,
          \App\Infra\FraudCheckers\FraudCheckerTwoSDK::class,
     ];

     /**
     * @param  bool $orderReverse
     * @return array FraudCheckerIntegration
     */
     public static function getFraudCheckers(bool $orderReverse): array
     {
          try {
               $clientsCheckers = $orderReverse ? array_reverse(self::CLIENTS_CHECKERS) : self::CLIENTS_CHECKERS;
               return array_map(function($checkers) {
                    return new FraudCheckerIntegration(new $checkers());
               }, $clientsCheckers); 
           } catch (\Throwable $th) {
               throw new Exception(self::FAILURE_CREATE_CLIENT);
           }    
     }
}