<?php

declare(strict_types=1);

namespace Unit\Domain\Services;

use App\Domain\Services\FraudChecker;
use App\Domain\Entities\Transaction;
use PHPUnit\Framework\TestCase;

class FraudCheckerTest extends TestCase
{
    private $fraudChecker;
    private $transaction;
    
    protected function setUp(): void
    {
        $this->fraudChecker = new FraudChecker();
        $this->transaction = $this->createMock(Transaction::class);
    }

    /**
     * @dataProvider checkSuccesProvider
     */
    public function testCheckSuccess($orderReverse, $simulateAuthorized, $expected)
    {  
        $result = $this->fraudChecker->check($this->transaction, $orderReverse, $simulateAuthorized);

        $this->assertEquals($result, $expected);
    }

    public function checkSuccesProvider(): array
    {
        return [
           'connect and authorized TRUE, reverse FALSE' => [
                'orderReverse' => false,
                'simulateAuthorized' => [
                    0 => ['connect' => true, 'authorized' => true], 
                    1 => ['connect' => true, 'authorized' => true], 
                ],
                'expected' => true,
           ],
           'connect and authorized TRUE, reverse TRUE' => [
                'orderReverse' => true,
                'simulateAuthorized' => [
                    0 => ['connect' => true, 'authorized' => true], 
                    1 => ['connect' => true, 'authorized' => true], 
                ],
                'expected' => true,
           ],
           'connect0 FALSE, authorized0 FALSE, connect1 TRUE, authorized1 TRUE, reverse FALSE' => [
                'orderReverse' => false,
                'simulateAuthorized' => [
                    0 => ['connect' => false, 'authorized' => false], 
                    1 => ['connect' => true, 'authorized' => true], 
                ],
                'expected' => true,
           ],
           'connect0 FALSE, authorized0 FALSE, connect1 TRUE, authorized1 TRUE, reverse TRUE' => [
                'orderReverse' => true,
                'simulateAuthorized' => [
                    0 => ['connect' => false, 'authorized' => false], 
                    1 => ['connect' => true, 'authorized' => true], 
                ],
                'expected' => true,
            ],
        ];
    }

    /**
     * @dataProvider checkFailureProvider
     */
    public function testCheckFailure($orderReverse, $simulateAuthorized, $expected)
    {
        $result = $this->fraudChecker->check($this->transaction, $orderReverse, $simulateAuthorized);

        $this->assertEquals($result, $expected);
    }

    public function checkFailureProvider(): array
    {
        return [
           'connect and authorized FALSE, reverse FALSE' => [
                'orderReverse' => false,
                'simulateAuthorized' => [
                    0 => ['connect' => false, 'authorized' => false], 
                    1 => ['connect' => false, 'authorized' => false], 
                ],
                'expected' => false,
           ],
           'connect FALSE, authorized TRUE, reverse FALSE' => [
                'orderReverse' => false,
                'simulateAuthorized' => [
                    0 => ['connect' => false, 'authorized' => true], 
                    1 => ['connect' => false, 'authorized' => true], 
                ],
                'expected' => false,
           ],
           'connect0 FALSE, authorized0 FALSE, connect1 TRUE, authorized1 TRUE, reverse FALSE' => [
                'orderReverse' => false,
                'simulateAuthorized' => [
                    0 => ['connect' => false, 'authorized' => true], 
                    1 => ['connect' => true, 'authorized' => false], 
                ],
                'expected' => false,
           ]
        ];
    }
}
