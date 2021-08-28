<?php

declare(strict_types=1);

namespace App\Domain\Libraries;

use App\Domain\Contracts\TaxManagerClientInterface;

class TaxManagerLibrary implements TaxManagerClientInterface
{

    private const DEFAULT_INCREMENT_VALUE = 5.14;

    public function getIncrementValue(float $tax): float
    {
        return self::DEFAULT_INCREMENT_VALUE;
    }

}
