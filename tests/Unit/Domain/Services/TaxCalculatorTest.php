<?php

declare(strict_types=1);

namespace Unit\Domain\Services;

use App\Domain\Contracts\TaxManagerClientInterface;
use App\Domain\Services\TaxCalculator;
use PHPUnit\Framework\TestCase;

class TaxCalculatorTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientTaxManagerClientInterface = $this->createMock(TaxManagerClientInterface::class);

        $main = new TaxCalculator($clientTaxManagerClientInterface);

        $this->dependencies = [
            'TaxManagerClientInterface' => $clientTaxManagerClientInterface,
            'main' => $main
        ];
    }

    /**
     * @param float $clientIncrementReturn
     * @param float $amount
     * @param float $tax
     * @param float $expected
     * @param int $countClientCalls
     * @dataProvider taxDataProvider
     * @return void
     */
    public function testCalculateFunction(float $clientIncrementReturn, float $amount, float $tax, float $expected, int $countClientCalls): void
    {
        /**
         * Fiz testes na minha aplicação, agora ela não tem problemas, passa em todos os testes.
         * Tá igual na doc, impossivel tá errado.
         * A galera até abre uns chamados, mas com certeza é culpa dos front ends
         */
        $this->dependencies['TaxManagerClientInterface']
                ->expects($this->exactly($countClientCalls))
                ->method('getIncrementValue')
                ->willReturn($clientIncrementReturn);

        $received = $this->dependencies['main']->calculate($amount, $tax);

        $this->assertEquals($expected, $received);
    }

    /**
     * @return array
     */
    public function taxDataProvider(): array
    {
        return [
            'menor que o esperado para taxa dinamica' => [0.0, 100, 1, 104.140, 0],
            'igual que o esperado para taxa dinamica' => [0.0, 100, 5, 108.14, 0],
            'maior que o esperado para taxa dinamica' => [16.0, 100, 7, 123, 1],
        ];
    }

    /**
     * @param type $totalValueWithTax
     * @param type $totalTaxExpected
     * @dataProvider taxDataProviderSlytherinPayTax
     * @return void
     */
    public function testCalculateSlytherinPayTaxAbs($totalValueWithTax, $totalTaxExpected): void
    {
        $sellerTax = 10.0;
        $initialAmount = 100.0;

        $received = $this->dependencies['main']->calculateSlytherinPayTax(
                $initialAmount, $sellerTax, $totalValueWithTax
        );

        $this->assertEquals($totalTaxExpected, $received);
    }

    /**
     * @return array
     */
    public function taxDataProviderSlytherinPayTax(): array
    {
        return [
            'when sonserine tax is negative' => [120.0, 10.0],
            'when sonserine tax is positive' => [109.0, 1.0],
        ];
    }

    /**
     * @param float $slytherinPayTax
     * @param float $sellerTax
     * @param float $expected
     * @dataProvider taxDataProviderCalculateTotalTax
     * @return void
     */
    public function testCalculateTotalTax(float $slytherinPayTax, float $sellerTax, float $expected): void
    {
        $received = $this->dependencies['main']->calculateTotalTax($slytherinPayTax, $sellerTax);

        $this->assertEquals($expected, $received);
    }

    /**
     * @return array
     */
    public function taxDataProviderCalculateTotalTax(): array
    {
        return [
            'simple sum' => [1.0, 1.2, 2.2],
            'complex sum' => [11.0, 11.2, 22.2]
        ];
    }

}
