<?php

declare(strict_types=1);

namespace Unit\Domain\Entities;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Buyer;

class BuyerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $main = new Buyer();

        $this->dependencies = [
            'main' => $main
        ];
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

}
