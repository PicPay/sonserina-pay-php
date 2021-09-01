<?php

declare(strict_types=1);

namespace Unit\Domain\Services;

use App\Domain\Services\FraudChecker;
use App\Domain\Entities\Transaction;
use App\Domain\Factorys\FraudCheckers\FraudCheckerFactory;
use Exception;
use PHPUnit\Framework\TestCase;

class FrauCheckerTest extends TestCase
{
    private $fraudChecker;
    
    protected function setUp(): void
    {
        $this->fraudChecker = new FraudChecker();
    }

    #./vendor/bin/phpunit tests/Unit/Domain/Services/FrauCheckerTest.php


    public function testCheckSuccess()
    {
        $transaction = $this->createMock(Transaction::class);
        $result = $this->fraudChecker->check($transaction);
        $expected = true;

        $this->assertEquals($result, $expected);
    }
}
