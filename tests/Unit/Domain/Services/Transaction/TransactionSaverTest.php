<?php

declare(strict_types=1);

namespace Unit\Domain\Services\Transaction;

use PHPUnit\Framework\TestCase;
use App\Domain\Services\Transaction\TransactionSaver;
use App\Domain\Entities\Transaction;
use App\Domain\Repositories\TransactionRepository;

class TransactionSaverTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientTransactionRepository = $this->createMock(TransactionRepository::class);
        $clientTransaction = $this->createMock(Transaction::class);

        $main = new TransactionSaver($clientTransactionRepository);

        $this->dependencies = [
            'TransactionRepository' => $clientTransactionRepository,
            'Transaction' => $clientTransaction,
            'main' => $main
        ];
    }

    public function testProcess(): void
    {
        $this->dependencies['TransactionRepository']->expects($this->exactly(1))
                ->method('save')
                ->with($this->dependencies['Transaction'])
                ->willReturn($this->dependencies['Transaction']);

        $this->assertSame(
                $this->dependencies['main']->process($this->dependencies['Transaction']),
                $this->dependencies['Transaction'],
        );
    }

}
