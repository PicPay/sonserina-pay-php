<?php

declare(strict_types=1);

namespace Unit\Domain\Libraries\FrauChecker;

use PHPUnit\Framework\TestCase;
use App\Domain\Libraries\FraudChecker\FraudCheckerIterator;

class FraudCheckerIteratorTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $main = new FraudCheckerIterator();

        $this->dependencies = [
            'main' => $main
        ];
    }

    public function testIsLastChecker(): void
    {
        $this->assertTrue($this->dependencies['main']->isLastChecker());
    }

    public function testIncrementCheckerCount(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('checkerCounter');
        $property->setAccessible(true);

        $old = $property->getValue($this->dependencies['main']);
        $this->dependencies['main']->incrementCheckerCount();
        $new = $property->getValue($this->dependencies['main']);

        $this->assertEquals($old + 1, $new);
    }

    public function testGetListLength(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('listLength');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], 5);

        $this->assertSame(
                5,
                $this->dependencies['main']->getListLength()
        );
    }

    public function testSetCheckersList(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));

        $this->dependencies['main']->setCheckersList([1, 2]);

        $listLengthProperty = $reflection->getProperty('listLength');
        $listLengthProperty->setAccessible(true);
        $this->assertEquals(2, $listLengthProperty->getValue($this->dependencies['main']));

        $checkersListProperty = $reflection->getProperty('checkersList');
        $checkersListProperty->setAccessible(true);
        $this->assertEquals([1, 2], $checkersListProperty->getValue($this->dependencies['main']));
    }

}
