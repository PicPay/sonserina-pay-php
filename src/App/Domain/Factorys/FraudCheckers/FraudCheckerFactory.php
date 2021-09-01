<?php

declare(strict_types=1);

namespace App\Domain\Factorys\FraudCheckers;

use App\Domain\Infra\FraudCheckers\FraudCheckerOneAPI;
use App\Domain\Infra\FraudCheckers\FraudCheckerTwoSDK;
use App\Domain\Infra\Integrations\FraudCheckerIntegration;

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