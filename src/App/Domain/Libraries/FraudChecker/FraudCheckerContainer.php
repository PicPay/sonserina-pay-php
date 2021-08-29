<?php

declare(strict_types=1);

namespace App\Domain\Libraries\FraudChecker;

class FraudCheckerContainer
{

    /**
     * @var array 
     */
    private array $servicesConsulting = [
        \App\Domain\Libraries\FraudChecker\Vendor\API::class,
        \App\Domain\Libraries\FraudChecker\Vendor\SDK::class
    ];

    /**
     * @return array
     */
    public function getServices(): array
    {
        return array_map(function($class) {
            return new $class();
        }, $this->servicesConsulting);
    }

}
