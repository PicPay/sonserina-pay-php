<?php

declare(strict_types=1);

namespace Unit\Domain\Services\Transaction;

use PHPUnit\Framework\TestCase;
use App\Domain\Services\Transaction\TransactionConfigurator;
use App\Domain\Entities\Transaction;
use App\Domain\Services\FraudChecker;

class TransactionConfiguratorTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientFraudChecker = $this->createMock(FraudChecker::class);
        $clientTransaction = $this->createMock(Transaction::class);

        $main = new TransactionConfigurator();

        $this->dependencies = [
            'FraudChecker' => $clientFraudChecker,
            'Transaction' => $clientTransaction,
            'main' => $main
        ];
    }

    public function testProcessPerfect(): void
    {
        $complement = [
            'totalTax' => 15.0,
            'sonserinaPay' => 5.0,
            'totalValueWithTax' => 20.0
        ];

        $this->dependencies['Transaction']->expects($this->exactly(1))
                ->method('setCreatedDate');
        $this->dependencies['Transaction']->expects($this->exactly(1))
                ->method('setTotalTax')
                ->with(15.0);
        $this->dependencies['Transaction']->expects($this->exactly(1))
                ->method('setSlytherinPayTax')
                ->with(5.0);
        $this->dependencies['Transaction']->expects($this->exactly(1))
                ->method('setTotalAmount')
                ->with(20.0);

        $this->assertNull($this->dependencies['main']->process($this->dependencies['Transaction'], $complement));
    }

    /**
     * @dataProvider taxDataProvider
     */
    public function testProcessException($complement): void
    {
        $this->dependencies['Transaction']->expects($this->never())
                ->method('setCreatedDate');
        $this->dependencies['Transaction']->expects($this->never())
                ->method('setTotalTax');
        $this->dependencies['Transaction']->expects($this->never())
                ->method('setSlytherinPayTax');
        $this->dependencies['Transaction']->expects($this->never())
                ->method('setTotalAmount');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('It was not possible to perform the configuration with the sent parameters');

        $this->dependencies['main']->process($this->dependencies['Transaction'], $complement);
    }

    public function taxDataProvider(): array
    {
        return [
            'invalid complement null' => [null],
            'invalid complement number' => [2],
            'invalid complement string' => ['string'],
            'invalid complement true' => [true],
            'invalid complement object' => [new \stdClass()],
            'invalid complement without totalTax' => [['sonserinaPay' => true, 'totalValueWithTax' => true]],
            'invalid complement without sonserinaPay' => [['totalTax' => true, 'totalValueWithTax' => true]],
            'invalid complement without totalValueWithTax' => [['sonserinaPay' => true, 'totalTax' => true]],
            'invalid complement invalid totalTax' => [['totalTax' => 1, 'sonserinaPay' => 1.0, 'totalValueWithTax' => 1.0]],
            'invalid complement invalid sonserinaPay' => [['sonserinaPay' => 1, 'totalTax' => 1.0, 'totalValueWithTax' => 1.0]],
            'invalid complement invalid totalValueWithTax' => [['totalValueWithTax' => 1, 'sonserinaPay' => 1.0, 'totalTax' => 1.0]],
        ];
    }

}
