<?php

declare(strict_types=1);

namespace Unit\Domain\Services;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Transaction;
use App\Domain\Services\Transaction\TransactionChecker;
use App\Domain\Services\Transaction\TransactionCalculator;
use App\Domain\Services\Transaction\TransactionConfigurator;
use App\Domain\Services\Transaction\TransactionSaver;
use App\Domain\Services\Transaction\TransactionNotifier;
use App\Domain\Services\TransactionHandler;

class TransactionHandlerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientTransactionChecker = $this->createMock(TransactionChecker::class);
        $clientTransactionCalculator = $this->createMock(TransactionCalculator::class);
        $clientTransactionConfigurator = $this->createMock(TransactionConfigurator::class);
        $clientTransactionSaver = $this->createMock(TransactionSaver::class);
        $clientTransactionNotifier = $this->createMock(TransactionNotifier::class);
        $clientTransaction = $this->createMock(Transaction::class);

        $main = new TransactionHandler(
                $clientTransactionChecker,
                $clientTransactionCalculator,
                $clientTransactionConfigurator,
                $clientTransactionSaver,
                $clientTransactionNotifier
        );

        $this->dependencies = [
            'TransactionChecker' => $clientTransactionChecker,
            'TransactionCalculator' => $clientTransactionCalculator,
            'TransactionConfigurator' => $clientTransactionConfigurator,
            'TransactionSaver' => $clientTransactionSaver,
            'TransactionNotifier' => $clientTransactionNotifier,
            'Transaction' => $clientTransaction,
            'main' => $main
        ];
    }

    public function testCreate(): void
    {
        $this->dependencies['TransactionChecker']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction']);
        $this->dependencies['TransactionCalculator']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction'])
                ->willReturn(['xx-calculator' => 1]);
        $this->dependencies['TransactionConfigurator']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction'], ['xx-calculator' => 1]);
        $this->dependencies['TransactionSaver']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction']);
        $this->dependencies['TransactionNotifier']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction']);

        $received = $this->dependencies['main']->create($this->dependencies['Transaction']);
        $this->assertSame($this->dependencies['Transaction'], $received);
    }

    public function testCreateCheckerException(): void
    {
        $this->dependencies['TransactionChecker']->expects($this->exactly(1))
                ->method('process')
                ->will($this->throwException(new \Exception()))
                ->with($this->dependencies['Transaction']);
        $this->dependencies['TransactionCalculator']->expects($this->never())
                ->method('process');
        $this->dependencies['TransactionConfigurator']->expects($this->never())
                ->method('process');
        $this->dependencies['TransactionSaver']->expects($this->never())
                ->method('process');
        $this->dependencies['TransactionNotifier']->expects($this->never())
                ->method('process');

        $received = $this->dependencies['main']->create($this->dependencies['Transaction']);
        $this->assertSame($this->dependencies['Transaction'], $received);
    }

    public function testCreateCalculatorException(): void
    {
        $this->dependencies['TransactionChecker']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction']);
        $this->dependencies['TransactionCalculator']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction'])
                ->will($this->throwException(new \Exception()));
        $this->dependencies['TransactionConfigurator']->expects($this->never())
                ->method('process');
        $this->dependencies['TransactionSaver']->expects($this->never())
                ->method('process');
        $this->dependencies['TransactionNotifier']->expects($this->never())
                ->method('process');

        $received = $this->dependencies['main']->create($this->dependencies['Transaction']);
        $this->assertSame($this->dependencies['Transaction'], $received);
    }

    public function testCreateConfiguratorException(): void
    {
        $this->dependencies['TransactionChecker']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction']);
        $this->dependencies['TransactionCalculator']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction'])
                ->willReturn(['xx-calculator' => 1]);
        $this->dependencies['TransactionConfigurator']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction'], ['xx-calculator' => 1])
                ->will($this->throwException(new \Exception()));
        $this->dependencies['TransactionSaver']->expects($this->never())
                ->method('process');
        $this->dependencies['TransactionNotifier']->expects($this->never())
                ->method('process');

        $received = $this->dependencies['main']->create($this->dependencies['Transaction']);
        $this->assertSame($this->dependencies['Transaction'], $received);
    }

    public function testCreateSaverException(): void
    {
        $this->dependencies['TransactionChecker']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction']);
        $this->dependencies['TransactionCalculator']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction'])
                ->willReturn(['xx-calculator' => 1]);
        $this->dependencies['TransactionConfigurator']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction'], ['xx-calculator' => 1]);
        $this->dependencies['TransactionSaver']->expects($this->exactly(1))
                ->method('process')
                ->with($this->dependencies['Transaction'])
                ->will($this->throwException(new \Exception()));
        $this->dependencies['TransactionNotifier']->expects($this->never())
                ->method('process');

        $received = $this->dependencies['main']->create($this->dependencies['Transaction']);
        $this->assertSame($this->dependencies['Transaction'], $received);
    }

}
