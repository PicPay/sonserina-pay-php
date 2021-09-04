<?php

declare(strict_types=1);

namespace App\Domain\Dale;

use App\Domain\Contracts\TaxManagerClientInterface;

class TaxManagerClient implements TaxManagerClientInterface
{
    private const DEFAULT_INCREMENT_VALUE = 3.14;

    /**
     * @param float $tax
     * @return float
     */
    public function getIncrementValue(float $tax): float
    {
        return self::DEFAULT_INCREMENT_VALUE;
    }
}
