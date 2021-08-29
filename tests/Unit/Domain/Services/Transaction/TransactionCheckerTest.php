<?php

declare(strict_types=1);

namespace Unit\Domain\Services\Transaction;

use PHPUnit\Framework\TestCase;
use App\Domain\Services\Transaction\TransactionChecker;
use App\Domain\Entities\Transaction;
use App\Domain\Services\FraudChecker;

class TransactionCheckerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientFraudChecker = $this->createMock(FraudChecker::class);
        $clientTransaction = $this->createMock(Transaction::class);

        $main = new TransactionChecker($clientFraudChecker);

        $this->dependencies = [
            'FraudChecker' => $clientFraudChecker,
            'Transaction' => $clientTransaction,
            'main' => $main
        ];
    }

    public function testProcessPerfect(): void
    {
        $this->dependencies['FraudChecker']->expects($this->exactly(1))
                ->method('check')
                ->with($this->dependencies['Transaction'])
                ->willReturn(true);

        $this->assertNull($this->dependencies['main']->process($this->dependencies['Transaction']));
    }

    public function testProcessException(): void
    {
        $this->dependencies['FraudChecker']->expects($this->exactly(1))
                ->method('check')
                ->with($this->dependencies['Transaction'])
                ->willReturn(false);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failure of fraud verification rules.');

        $this->dependencies['main']->process($this->dependencies['Transaction']);
    }

}
