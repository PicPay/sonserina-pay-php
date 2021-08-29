<?php

declare(strict_types=1);

namespace Unit\Domain\Repositories;

use PHPUnit\Framework\TestCase;
use App\Domain\Libraries\NotifierLibrary;
use App\Domain\Entities\Notification;
use App\Domain\Entities\Transaction;
use App\Domain\Entities\Buyer;

class NotifierLibraryTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientTransaction = $this->createMock(Transaction::class);
        $clientNotification = $this->createMock(Notification::class);
        $clientBuyer = $this->createMock(Buyer::class);

        $main = new NotifierLibrary();

        $this->dependencies = [
            'Transaction' => $clientTransaction,
            'Notification' => $clientNotification,
            'Buyer' => $clientBuyer,
            'main' => $main
        ];
    }

    public function testConfigure(): void
    {
        $this->dependencies['Transaction']->expects($this->exactly(1))
                ->method('getBuyer')
                ->with()
                ->willReturn($this->dependencies['Buyer']);

        $this->dependencies['Buyer']->expects($this->exactly(1))
                ->method('getEmail')
                ->with()
                ->willReturn('joseph@php.com');

        $notification = $this->dependencies['main']->configure($this->dependencies['Transaction']);
        $notificationReflection = (new \ReflectionClass($notification));

        $property = $notificationReflection->getProperty('email');
        $property->setAccessible(true);

        $this->assertEquals(
                $property->getValue($notification),
                'joseph@php.com',
        );
    }

    public function testNotify(): void
    {
        $this->dependencies['Notification']->expects($this->exactly(1))
                ->method('getEmail')
                ->with()
                ->willReturn('joseph@php.com');

        $this->expectOutputString('Notifying ... [joseph@php.com]' . PHP_EOL);

        $this->assertNull($this->dependencies['main']->notify($this->dependencies['Notification']));
    }

    public function testGetNotification(): void
    {
        $newObject = $this->dependencies['Notification'];

        $notificationReflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $notificationReflection->getProperty('notification');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], $newObject);

        $this->assertSame(
                $newObject,
                $this->dependencies['main']->getNotification()
        );
    }

}
