<?php

declare(strict_types=1);

namespace Unit\Domain\Services\Transaction;

use PHPUnit\Framework\TestCase;
use App\Domain\Services\Transaction\TransactionCalculator;
use App\Domain\Services\TaxCalculator;
use App\Domain\Entities\Transaction;

class TransactionCalculatorTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientTaxCalculator = $this->createMock(TaxCalculator::class);
        $clientTransaction = $this->createMock(Transaction::class);

        $main = new TransactionCalculator($clientTaxCalculator);

        $this->dependencies = [
            'TaxCalculator' => $clientTaxCalculator,
            'Transaction' => $clientTransaction,
            'main' => $main
        ];
    }

    public function testProcess(): void
    {
        $sellerTax = 10.0;
        $initialAmount = 100.0;
        $totalAmount = 113.14;
        $totalTax = 13.14;
        $slytherinPay = 3.14;

        $this->dependencies['Transaction']->expects($this->exactly(1))
                ->method('getSellerTax')
                ->with()
                ->willReturn($sellerTax);

        $this->dependencies['Transaction']->expects($this->exactly(1))
                ->method('getInitialAmount')
                ->with()
                ->willReturn($initialAmount);

        $this->dependencies['TaxCalculator']->expects($this->exactly(1))
                ->method('calculate')
                ->with($initialAmount, $sellerTax)
                ->willReturn($totalAmount);

        $this->dependencies['TaxCalculator']->expects($this->exactly(1))
                ->method('calculateSlytherinPayTax')
                ->with($initialAmount, $sellerTax, $totalAmount)
                ->willReturn($slytherinPay);

        $this->dependencies['TaxCalculator']->expects($this->exactly(1))
                ->method('calculateTotalTax')
                ->with($slytherinPay, $sellerTax)
                ->willReturn($totalTax);

        $received = $this->dependencies['main']->process($this->dependencies['Transaction']);

        $this->assertTrue(isset($received['sellerTax']));
        $this->assertTrue(isset($received['totalValueWithTax']));
        $this->assertTrue(isset($received['totalTax']));
        $this->assertTrue(isset($received['slytherinPay']));

        $this->assertEquals($received['sellerTax'], $sellerTax);
        $this->assertEquals($received['totalValueWithTax'], $totalAmount);
        $this->assertEquals($received['totalTax'], $totalTax);
        $this->assertEquals($received['slytherinPay'], $slytherinPay);
    }

}
