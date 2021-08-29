<?php

declare(strict_types=1);

namespace Unit\Domain\Services\Transaction;

use PHPUnit\Framework\TestCase;
use App\Domain\Services\Transaction\TransactionNotifier;
use App\Domain\Entities\Transaction;
use App\Domain\Services\Notifier;
use App\Domain\Entities\Notification;
use App\Domain\Libraries\NotifierLibrary;

class TransactionNotifierTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientNotifier = $this->createMock(Notifier::class);
        $clientNotifierLibrary = $this->createMock(NotifierLibrary::class);
        $clientTransaction = $this->createMock(Transaction::class);
        $clientNotification = $this->createMock(Notification::class);

        $main = new TransactionNotifier($clientNotifier);

        $this->dependencies = [
            'Notifier' => $clientNotifier,
            'NotifierLibrary' => $clientNotifierLibrary,
            'Transaction' => $clientTransaction,
            'Notification' => $clientNotification,
            'main' => $main
        ];
    }

    public function testProcess(): void
    {
        $this->dependencies['Notifier']->expects($this->exactly(1))
                ->method('getClient')
                ->with()
                ->willReturn($this->dependencies['NotifierLibrary']);

        $this->dependencies['NotifierLibrary']->expects($this->exactly(1))
                ->method('configure')
                ->with($this->dependencies['Transaction'])
                ->willReturn($this->dependencies['Notification']);

        $this->dependencies['Notifier']->expects($this->exactly(1))
                ->method('notify')
                ->with($this->dependencies['Notification']);

        $this->assertNull($this->dependencies['main']->process($this->dependencies['Transaction']));
    }

}
