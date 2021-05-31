<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Clients\TaxManagerClientInterface;

class TaxCalculator
{
    private const DEFAULT_INCREMENT_VALUE = 3.14;

    /**
     * @var TaxManagerClientInterface
     */
    private TaxManagerClientInterface $client;

    /**
     * TaxCalculator constructor.
     * @param TaxManagerClientInterface $client
     */
    public function __construct(TaxManagerClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param float $tax
     * @return float
     */
    private function getRealTaxValue(float $tax): float
    {
        $increment = self::DEFAULT_INCREMENT_VALUE;
        if ($tax > 5) {
            $increment = $this->client->getIncrementValue($tax);
        }
        return 1 + (($increment + $tax) / 100);
    }

    /**
     * @param float $amount
     * @param float $tax
     * @return float
     */
    public function calculate(float $amount, float $tax): float
    {
        return $amount * $this->getRealTaxValue($tax);
    }
}
