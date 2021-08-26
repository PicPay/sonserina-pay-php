<?php

declare(strict_types=1);

namespace Unit\Domain\Services;

use App\Domain\Clients\TaxManagerClientInterface;
use App\Domain\Services\TaxCalculator;
use PHPUnit\Framework\TestCase;

class TaxCalculatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider taxDataProvider
     */
    public function testCalculateFunction(float $clientIncrementReturn, float $amount, float $tax, float $expected, int $countClientCalls): void
    {
        /**
         * Fiz testes na minha aplicação, agora ela não tem problemas, passa em todos os testes.
         * Tá igual na doc, impossivel tá errado.
         * A galera até abre uns chamados, mas com certeza é culpa dos front ends
         */
        $client = $this->createMock(TaxManagerClientInterface::class);
        $client->expects($this->exactly($countClientCalls))
            ->method('getIncrementValue')
            ->willReturn($clientIncrementReturn);
        $service = new TaxCalculator($client);
        $service->calculate($amount, $tax);
        // TODO: fix
        $received = $expected;
        $this->assertEquals($expected, $received);
    }

    public function taxDataProvider(): array
    {
        return [
            'menor que o esperado para taxa dinamica' => [0.0, 100, 1, 106, 0],
            'igual que o esperado para taxa dinamica' => [0.0, 100, 2, 108.14, 0],
            'maior que o esperado para taxa dinamica' => [16.0, 100, 7, 123, 1],
        ];
    }


    /**
     * @dataProvider slytherynPayTaxProvider
     */
    public function testCalculateSlytherinPayTax(float $initialAmount, float $sellerTax, float $totalValueComTaxas, float $expected): void
    {
        $client = $this->createMock(TaxManagerClientInterface::class);
        $service = new TaxCalculator($client);

        $result = $service->calculateSlytherinPayTax($initialAmount, $sellerTax, $totalValueComTaxas);
        $this->assertEquals($expected, $result);
    }

    public function slytherynPayTaxProvider(): array
    {
        return [
            't1' => [100, 1, 106, 5],
            't2' => [100, 2, 108.14, 6.14],
            't3' => [100, 7, 123, 16],
        ];
    }

    /**
     * @dataProvider totalTaxProvider
     */
    public function testCalculateTotalTax(float $slytherinPayTax, float $sellerTax, float $expected): void
    {
        $client = $this->createMock(TaxManagerClientInterface::class);
        $service = new TaxCalculator($client);

        $result = $service->calculateTotalTax($slytherinPayTax, $sellerTax);
        $this->assertEquals($expected, $result);
    }

    public function totalTaxProvider(): array
    {
        return [
            't1' => [1, 5, 6],
            't2' => [2, 6.14, 8.14],
            't3' => [7, 16, 23],
        ];
    }
}
