<?php

declare(strict_types=1);

namespace App\Domain\Clients;

/**
 * Interface TaxManagerClientInterface
 * @package App\Domain\Clients
 */
interface TaxManagerClientInterface
{
    /**
     * @param float $amount
     * @return float
     */
    public function getIncrementValue(float $tax): float;
}
