<?php

declare(strict_types=1);

namespace Unit\Domain\Services;

use App\Domain\Services\FraudChecker;
use App\Domain\Entities\Transaction;
use Exception;
use PHPUnit\Framework\TestCase;

class FraudCheckerTest extends TestCase
{
    private $fraudChecker;
    
    protected function setUp(): void
    {
        $this->fraudChecker = new FraudChecker();
    }

    #./vendor/bin/phpunit tests/Unit/Domain/Services/FraudCheckerTest.php


    public function testCheckSuccess()
    {
        $simulateConnect = [
            0 => ['connect' => true], 
            1 => ['connect' => true]
        ];
        $orderReverse = false;

        $transaction = $this->createMock(Transaction::class);
        $result = $this->fraudChecker->check($transaction, $orderReverse, $simulateConnect);
        $expected = true;

        $this->assertEquals($result, $expected);
    }
}
