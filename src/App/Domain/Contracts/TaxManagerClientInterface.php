<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

/**
 * Interface TaxManagerClientInterface
 * @package App\Domain\Contracts
 */
interface TaxManagerClientInterface
{

    /**
     * @param float $amount
     * @return float
     */
    public function getIncrementValue(float $tax): float;
}
