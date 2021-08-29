<?php

declare(strict_types=1);

namespace Unit\Domain\Repositories;

use PHPUnit\Framework\TestCase;
use App\Domain\Libraries\TaxManagerLibrary;

class TaxManagerLibraryTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $main = new TaxManagerLibrary();

        $this->dependencies = [
            'main' => $main
        ];
    }

    public function testGetIncrementValue(): void
    {
        $value = (new \ReflectionClass(TaxManagerLibrary::class))->getConstant('DEFAULT_INCREMENT_VALUE');

        $this->assertEquals(
                $this->dependencies['main']->getIncrementValue(1.0),
                $value,
        );
    }

}
