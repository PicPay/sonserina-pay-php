<?php

declare(strict_types=1);

namespace Unit\Domain\Services;

use PHPUnit\Framework\TestCase;
use App\Domain\Services\FraudChecker;
use App\Domain\Libraries\FraudChecker\FraudCheckerContainer;
use App\Domain\Libraries\FraudChecker\FraudCheckerIterator;
use App\Domain\Exceptions\FraudCheckerEmptyException;
use App\Domain\Exceptions\FraudCheckerNotAuthorizedException;
use App\Domain\Entities\Transaction;
use App\Domain\Libraries\FraudChecker\Vendor\API;

class FraudCcheckerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $clientContainer = $this->createMock(FraudCheckerContainer::class);
        $clientIterator = $this->createMock(FraudCheckerIterator::class);
        $clientTransaction = $this->createMock(Transaction::class);
        $clientApi = $this->createMock(API::class);

        $main = new FraudChecker($clientContainer, $clientIterator);

        $this->dependencies = [
            'FraudCheckerContainer' => $clientContainer,
            'FraudCheckerIterator' => $clientIterator,
            'Transaction' => $clientTransaction,
            'API' => $clientApi,
            'main' => $main
        ];
    }

    public function testGetIterator(): void
    {
        $received = $this->dependencies['main']->getIterator();

        $this->assertSame($received, $this->dependencies['FraudCheckerIterator']);
    }

    public function testGetContainer(): void
    {
        $received = $this->dependencies['main']->getContainer();

        $this->assertSame($received, $this->dependencies['FraudCheckerContainer']);
    }

    public function testCheckEmptyList(): void
    {
        $this->dependencies['FraudCheckerContainer']->expects($this->exactly(1))
                ->method('getServices')
                ->willReturn([]);
        $this->expectException(FraudCheckerEmptyException::class);
        $this->expectExceptionMessage('There are no anti-fraud checkers to proceed with the transaction');

        $this->dependencies['main']->check($this->dependencies['Transaction']);
    }

    /**
     * @dataProvider taxDataProvider
     */
    public function testCheck(array $config): void
    {
        $this->dependencies['FraudCheckerContainer']->expects($this->exactly(1))
                ->method('getServices')
                ->willReturn(array_fill(0, count($config), $this->dependencies['API']));

        foreach ($config as $row) {

            $this->dependencies['FraudCheckerIterator']->expects($this->exactly($row[0]))
                    ->method('incrementCheckerCount')
                    ->with();
            $this->dependencies['API']->expects($this->exactly($row[1]))
                    ->method('check')
                    ->with($this->dependencies['Transaction']);
            $this->dependencies['API']->expects($this->exactly($row[2]))
                    ->method('isAuthorized')
                    ->with()
                    ->willReturn($row[3]);

            if (isset($row[4])) {
                $this->dependencies['FraudCheckerIterator']
                        ->expects($this->exactly($row[4]))
                        ->method('isLastChecker')
                        ->with()
                        ->willReturn($row[5]);
            }
        }

        $received = $this->dependencies['main']->check($this->dependencies['Transaction']);
        $this->assertEquals($received, true);
    }

    public function taxDataProvider(): array
    {
        return [
            'aprovado na primeira tentativa' => [1 => [[1, 1, 1, true]]],
                //'aprovado na segunda tentativa' => [2 => [[2, 2, 2, false, 1, true, /* exception */]]],
        ];
    }

    public function testCheckNotAuthorized(): void
    {
        $this->dependencies['FraudCheckerContainer']->expects($this->exactly(1))
                ->method('getServices')
                ->willReturn([$this->dependencies['API']]);

        $this->dependencies['FraudCheckerIterator']->expects($this->exactly(1))
                ->method('incrementCheckerCount')
                ->with();
        $this->dependencies['API']->expects($this->exactly(1))
                ->method('check')
                ->with($this->dependencies['Transaction']);
        $this->dependencies['API']->expects($this->exactly(1))
                ->method('isAuthorized')
                ->with()
                ->willReturn(false);
        $this->dependencies['FraudCheckerIterator']
                ->expects($this->exactly(1))
                ->method('isLastChecker')
                ->with()
                ->willReturn(true);

        $this->expectException(FraudCheckerNotAuthorizedException::class);
        $this->expectExceptionMessage('The anti-fraud check did not authorize a transaction');

        $this->dependencies['main']->check($this->dependencies['Transaction']);
    }

}
