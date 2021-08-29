<?php

declare(strict_types=1);

namespace Unit\Domain\Libraries\FrauChecker;

use PHPUnit\Framework\TestCase;
use App\Domain\Libraries\FraudChecker\FraudCheckerContainer;

class FraudCheckerContainerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $main = new FraudCheckerContainer();

        $this->dependencies = [
            'main' => $main
        ];
    }

    public function testCountingGetServices(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('servicesConsulting');
        $property->setAccessible(true);
        $reflectionServices = $property->getValue($this->dependencies['main']);

        $services = $this->dependencies['main']->getServices();

        $this->assertEquals(count($reflectionServices), count($services));
    }

    public function testGetListLength(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('servicesConsulting');
        $property->setAccessible(true);
        $reflectionServices = $property->getValue($this->dependencies['main']);

        foreach ($this->dependencies['main']->getServices() as $key => $service) {
            $this->assertInstanceOf($reflectionServices[$key], $service);
        }
    }

}
