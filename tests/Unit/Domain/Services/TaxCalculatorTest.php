<?php

declare(strict_types=1);

namespace Unit\Domain\Services;

use App\Domain\Contracts\TaxManagerClientInterface;
use App\Domain\Services\TaxCalculator;
use App\Domain\Entities\Transaction;

use PHPUnit\Framework\TestCase;

class TaxCalculatorTest extends TestCase
{

    private $client;

    private $taxCalculator;

    private $transaction;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(TaxManagerClientInterface::class);
        $this->transaction = $this->createMock(Transaction::class);
        $this->taxCalculator = new TaxCalculator($this->client);
    }

    /**
     * @dataProvider taxDataProvider
     */
    public function testCalculateFunction(
        float $clientIncrementReturn, 
        float $amount, 
        float $tax, 
        float $expected, 
        int $countClientCalls
    ): void
    {
        $this->client->expects($this->exactly($countClientCalls))
            ->method('getIncrementValue')
            ->willReturn($clientIncrementReturn);
       
        $received = $this->taxCalculator->calculate($amount, $tax);
        
        $this->assertEquals($expected, $received);
    }

    public function taxDataProvider(): array
    {
        return [
            'menor que o esperado para taxa dinamica' => [0.0, 100, 1, 104.140, 0],
            'igual que o esperado para taxa dinamica' => [0.0, 100, 2, 105.140, 0],
            'maior que o esperado para taxa dinamica' => [16.0, 100, 7, 123, 1],
        ];
    }

    public function testCalculate()
    {  
        // Arrange
        $amount = 1.5;
        $tax = 1.9;
        $expected = 1.5756;

        // Act
        $received = $this->taxCalculator->calculate($amount, $tax );

        // Assert
        $this->assertEquals($expected, $received);
    }

    public function testCalculateSlytherinPayTax()
    {
        $initialAmount = 1.2;
        $sellerTax = 1.4;
        $totalValueWithTax = 6;
        $expected = 3.40;

        $received = $this->taxCalculator->calculateSlytherinPayTax($initialAmount, $sellerTax, $totalValueWithTax);
        $this->assertEquals($expected, $received);
    }


    public function testCalculateTotalTax()
    {
        $sellerTax = 1.4;
        $slytherinPayTax = 3.40;
        $expected = 4.80;
        
        $received = $this->taxCalculator->calculateTotalTax($sellerTax, $slytherinPayTax);
        $this->assertEquals($expected, $received);
    }


    /**
     * @dataProvider transactionTaxValuesProvider
     */
    public function testTransactionTaxValues($methods, $expected)
    {
        foreach ($methods as $method => $value) {
            $this->transaction->method($method)->willReturn($value);
        }
        
        $received = $this->taxCalculator->transactionTaxValues($this->transaction);

        $this->assertEquals($expected, $received);
    }

    public function transactionTaxValuesProvider(): array
    {
        return [
            'test succsses' => [
                'methods' => [
                    'getInitialAmount' => 1.2,
                    'getSellerTax' => 3.4,
                ],
                'expected' => [
                    'valueTotalWithTax' => 1.27848,
                    'slytherinPayTax' => 3.32152,
                    'totalTax' => 6.72152,
                ]
            ]
        ];
    }

    /**
     * @dataProvider transactionTaxValuesExceptionProvider
     */
    public function testTransactionTaxValuesException($methods)
    {
        foreach ($methods as $method => $value) {
            $this->transaction->method($method)->willReturn($value);
        }

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('incorrect values for transaction');
        
        $this->taxCalculator->transactionTaxValues($this->transaction);
    }

    public function transactionTaxValuesExceptionProvider(): array
    {
        return [
            'test failure getInitialAmount not set' => [
                'methods' => [
                    'getSellerTax' => 3.4,
                ],
            ],
            'test failure getSellerTax not set' => [
                'methods' => [
                    'getInitialAmount' => 3.4,
                ],
                'expected' => []
            ],
        ];
    }
}
