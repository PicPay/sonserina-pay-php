<?php

declare(strict_types=1);

namespace Unit\Domain\Services\Transaction;

use PHPUnit\Framework\TestCase;
use App\Domain\Services\Transaction\TransactionNotifier;
use App\Domain\Entities\Transaction;
use App\Domain\Services\Notifier;
use App\Domain\Entities\Notification;
use App\Domain\Libraries\NotifierLibrary;
use App\Domain\Entities\Buyer;
use App\Domain\Entities\Seller;

class TransactionNotifierTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientNotifier = $this->createMock(Notifier::class);
        $clientBuyer = $this->createMock(Buyer::class);
        $clientSeller = $this->createMock(Seller::class);
        $clientNotifierLibrary = $this->createMock(NotifierLibrary::class);
        $clientTransaction = $this->createMock(Transaction::class);
        $clientNotification = $this->createMock(Notification::class);

        $main = new TransactionNotifier($clientNotifier);

        $this->dependencies = [
            'Notifier' => $clientNotifier,
            'Buyer' => $clientBuyer,
            'Seller' => $clientSeller,
            'NotifierLibrary' => $clientNotifierLibrary,
            'Transaction' => $clientTransaction,
            'Notification' => $clientNotification,
            'main' => $main
        ];
    }

    public function testProcess(): void
    {
        $this->dependencies['Transaction']->expects($this->exactly(1))
                ->method('getBuyer')
                ->with()
                ->willReturn($this->dependencies['Buyer']);

        $this->dependencies['Transaction']->expects($this->exactly(1))
                ->method('getSeller')
                ->with()
                ->willReturn($this->dependencies['Seller']);

        $this->dependencies['Notifier']->expects($this->exactly(2))
                ->method('getClient')
                ->with()
                ->willReturn($this->dependencies['NotifierLibrary']);

        $this->dependencies['NotifierLibrary']->expects($this->exactly(2))
                ->method('configure')
                ->willReturn($this->dependencies['Notification']);

        $this->dependencies['Notifier']->expects($this->exactly(2))
                ->method('notify')
                ->with($this->dependencies['Notification']);

        $this->assertNull($this->dependencies['main']->process($this->dependencies['Transaction']));
    }

}
