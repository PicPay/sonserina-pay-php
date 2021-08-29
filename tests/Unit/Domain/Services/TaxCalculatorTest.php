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
     * @dataProvider taxDataProvider
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

    public function taxDataProvider(): array
    {
        return [
            'menor que o esperado para taxa dinamica' => [0.0, 100, 1, 104.140, 0],
            'igual que o esperado para taxa dinamica' => [0.0, 100, 5, 108.14, 0],
            'maior que o esperado para taxa dinamica' => [16.0, 100, 7, 123, 1],
        ];
    }

}
