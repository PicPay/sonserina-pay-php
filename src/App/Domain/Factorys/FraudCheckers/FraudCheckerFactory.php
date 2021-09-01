<?php

declare(strict_types=1);

namespace App\Domain\Factorys\FraudCheckers;

use App\Infra\FraudCheckers\FraudCheckerOneAPI;
use App\Infra\FraudCheckers\FraudCheckerTwoSDK;
use App\Infra\Integrations\FraudCheckerIntegration;

class FraudCheckerFactory
{

     /**
     * @return FraudCheckerIntegration
     */
     public static function getFraudCheckerIntegration($clientFRaudChecker):FraudCheckerIntegration
     {
          return new FraudCheckerIntegration($clientFRaudChecker);
     }
     /**
     * @return FraudCheckerOneAPI
     */
     public static function getFraudCheckerOne():FraudCheckerOneAPI
     {
          return new FraudCheckerOneAPI();
     }

    /**
     * @return FraudCheckerTwoSDK
     */
     public static function getFraudCheckerTwo():FraudCheckerTwoSDK
     {
          return new FraudCheckerTwoSDK();
     }
}