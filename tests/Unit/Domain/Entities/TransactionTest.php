<?php

declare(strict_types=1);

namespace Unit\Domain\Entities;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Transaction;
use App\Domain\Entities\Seller;
use App\Domain\Entities\Buyer;
use DateTime;

class TransactionTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientSeller = $this->createMock(Seller::class);
        $clientBuyer = $this->createMock(Buyer::class);
        $clientDateTime = $this->createMock(DateTime::class);

        $main = new Transaction();

        $this->dependencies = [
            'main' => $main,
            'Seller' => $clientSeller,
            'Buyer' => $clientBuyer,
            'DateTime' => $clientDateTime,
        ];
    }

    public function testGetBuyer(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('buyer');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], $this->dependencies['Buyer']);

        $expected = $this->dependencies['main']->getBuyer();

        $this->assertSame($expected, $this->dependencies['Buyer']);
    }

    public function testSetBuyer(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('buyer');

        $this->dependencies['main']->setBuyer($this->dependencies['Buyer']);

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertSame($expected, $this->dependencies['Buyer']);
    }

    public function testGetSeller(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('seller');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], $this->dependencies['Seller']);

        $expected = $this->dependencies['main']->getSeller();

        $this->assertSame($expected, $this->dependencies['Seller']);
    }

    public function testSetSeller(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('seller');

        $this->dependencies['main']->setSeller($this->dependencies['Seller']);

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertSame($expected, $this->dependencies['Seller']);
    }

    public function testGetCreatedDate(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('createdDate');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], $this->dependencies['DateTime']);

        $expected = $this->dependencies['main']->getCreatedDate();

        $this->assertSame($expected, $this->dependencies['DateTime']);
    }

    public function testSetCreatedDate(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('createdDate');

        $this->dependencies['main']->setCreatedDate($this->dependencies['DateTime']);

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertSame($expected, $this->dependencies['DateTime']);
    }

    public function testGetTotalAmount(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('totalAmount');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], 10.0);

        $expected = $this->dependencies['main']->getTotalAmount();

        $this->assertSame($expected, 10.0);
    }

    public function testSetTotalAmount(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('totalAmount');

        $this->dependencies['main']->setTotalAmount(10.0);

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertSame($expected, 10.0);
    }

    public function testGetTotalTax(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('totalTax');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], 10.1);

        $expected = $this->dependencies['main']->getTotalTax();

        $this->assertSame($expected, 10.1);
    }

    public function testSetTotalTax(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('totalTax');

        $this->dependencies['main']->setTotalTax(10.1);

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertSame($expected, 10.1);
    }

    public function testGetSlytherinPayTax(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('slytherinPayTax');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], 10.2);

        $expected = $this->dependencies['main']->getSlytherinPayTax();

        $this->assertSame($expected, 10.2);
    }

    public function testSetSlytherinPayTax(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('slytherinPayTax');

        $this->dependencies['main']->setSlytherinPayTax(10.2);

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertSame($expected, 10.2);
    }

    public function testGetSellerTax(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('sellerTax');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], 10.3);

        $expected = $this->dependencies['main']->getSellerTax();

        $this->assertSame($expected, 10.3);
    }

    public function testSetSellerTax(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('sellerTax');

        $this->dependencies['main']->setSellerTax(10.3);

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertSame($expected, 10.3);
    }

    public function testGetInitialAmount(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('initialAmount');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], 10.4);

        $expected = $this->dependencies['main']->getInitialAmount();

        $this->assertSame($expected, 10.4);
    }

    public function testSetInitialAmount(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('initialAmount');

        $this->dependencies['main']->setInitialAmount(10.4);

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertSame($expected, 10.4);
    }

    public function testGetId(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->dependencies['main'], 1);

        $expected = $this->dependencies['main']->getId();

        $this->assertEquals($expected, 1);
    }

    public function testSetId(): void
    {
        $reflection = (new \ReflectionClass($this->dependencies['main']));
        $property = $reflection->getProperty('id');

        $this->dependencies['main']->setId('1');

        $property->setAccessible(true);
        $expected = $property->getValue($this->dependencies['main']);

        $this->assertEquals($expected, '1');
    }

}
