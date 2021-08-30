<?php

declare(strict_types=1);

namespace Unit\Domain\Entities;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Notification;

class NotificationTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $main = new Notification();

        $this->dependencies = [
            'main' => $main
        ];
    }

    public function testSetMessage(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('message');

        $this->dependencies['main']->setMessage('xx');

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertSame($expected, 'xx');
    }

    public function testGetEmail(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('email');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], 'joseph@phpcode.com');

        $expected = $this->dependencies['main']->getEmail();

        $this->assertEquals($expected, 'joseph@phpcode.com');
    }

    public function testSetEmail(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('email');

        $this->dependencies['main']->setEmail('joseph@phpcode.com');

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertEquals($expected, 'joseph@phpcode.com');
    }

}
