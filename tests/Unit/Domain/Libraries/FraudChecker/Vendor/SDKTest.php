<?php

declare(strict_types=1);

namespace Unit\Domain\Libraries\FrauChecker\Vendor;

use PHPUnit\Framework\TestCase;
use App\Domain\Libraries\FraudChecker\Vendor\SDK;
use App\Domain\Entities\Transaction;

class SDKTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientTransaction = $this->createMock(Transaction::class);

        $main = new SDK();

        $this->dependencies = [
            'main' => $main,
            'Transaction' => $clientTransaction
        ];
    }

    public function testCheck(): void
    {
        $this->assertNull($this->dependencies['main']->check($this->dependencies['Transaction']));
    }

    public function testExtractMessageResponse(): void
    {
        $this->assertEquals('xx', $this->dependencies['main']->extractMessageResponse(
                        ['text' => 'xx', 'status' => true]
        ));
    }

    public function testIsAuthorizedTrue(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('status');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], true);

        $this->assertTrue($this->dependencies['main']->isAuthorized());
    }

}
