<?php

declare(strict_types=1);

namespace Unit\Domain\Services;

use App\Domain\Contracts\NotifierClientInterface;
use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Notification;
use App\Domain\Services\Notifier;

class NotifierTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientNotifier = $this->createMock(NotifierClientInterface::class);
        $clientNotification = $this->createMock(Notification::class);

        $main = new Notifier($clientNotifier);

        $this->dependencies = [
            'NotifierClientInterface' => $clientNotifier,
            'Notification' => $clientNotification,
            'main' => $main
        ];
    }

    public function testGetClient(): void
    {
        $received = $this->dependencies['main']->getClient();

        $this->assertSame($received, $this->dependencies['NotifierClientInterface']);
    }

    public function testNotify(): void
    {
        $this->dependencies['NotifierClientInterface']->expects($this->exactly(1))
                ->method('notify')
                ->with($this->dependencies['Notification']);

        $this->dependencies['main']->notify($this->dependencies['Notification']);
    }

}
