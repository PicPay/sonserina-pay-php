<?php

declare(strict_types=1);

namespace App\Domain\Libraries\FraudChecker;

class FraudCheckerContainer
{

    private $servicesConsulting = [
        \App\Domain\Libraries\FraudChecker\Vendor\SDK::class,
        \App\Domain\Libraries\FraudChecker\Vendor\API::class
    ];

    public function getServices(): array
    {
        return array_map(function($class) {
            return new $class();
        }, $this->servicesConsulting);
    }

}
