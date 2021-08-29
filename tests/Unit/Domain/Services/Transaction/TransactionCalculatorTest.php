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

    public function testProcessIndexes(): void
    {
        $sellerTax = 10.0;
        $initialAmount = 100.0;

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
                ->willReturn(113.14);

        $received = $this->dependencies['main']->process($this->dependencies['Transaction']);

        $this->assertTrue(isset($received['sellerTax']));
        $this->assertTrue(isset($received['totalValueWithTax']));
        $this->assertTrue(isset($received['totalTax']));
        $this->assertTrue(isset($received['sonserinaPay']));
    }

    /**
     * @dataProvider taxDataProvider
     */
    public function testProcessAbs($totalValueWithTax, $totalTaxExpected): void
    {
        $sellerTax = 10.0;
        $initialAmount = 100.0;

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
                ->willReturn($totalValueWithTax);

        $received = $this->dependencies['main']->process($this->dependencies['Transaction']);

        $this->assertEquals($totalTaxExpected, $received['totalTax']);
    }

    public function taxDataProvider(): array
    {
        return [
            'when sonserine tax is negative' => [120.0, 20.0],
            'when sonserine tax is positive' => [109.0, 11.0],
        ];
    }

}
