<?php

declare(strict_types=1);

namespace App\Domain\Libraries;

use App\Domain\Contracts\TaxManagerClientInterface;

class TaxManagerLibrary implements TaxManagerClientInterface
{

    public function getIncrementValue(float $tax): float
    {
        
    }

}
