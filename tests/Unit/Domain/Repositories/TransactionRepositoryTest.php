<?php

declare(strict_types=1);

namespace Unit\Domain\Repositories;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Transaction;
use App\Domain\Repositories\TransactionRepository;

class TransactionRepositoryTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientTransaction = $this->createMock(Transaction::class);

        $main = new TransactionRepository();

        $this->dependencies = [
            'Transaction' => $clientTransaction,
            'main' => $main
        ];
    }

    public function testProcess(): void
    {
        $this->assertSame(
                $this->dependencies['main']->save($this->dependencies['Transaction']),
                $this->dependencies['Transaction'],
        );
    }

}
