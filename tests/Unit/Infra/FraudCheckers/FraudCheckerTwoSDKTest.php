<?php

declare(strict_types=1);

namespace Unit\Infra\FraudCheckers;

use App\Infra\FraudCheckers\FraudCheckerTwoSDK;
use App\Domain\Entities\Transaction;
use PHPUnit\Framework\TestCase;

class FraudCheckerTwoSDKTest extends TestCase
{
    private $fraudChecker;
    private $transaction;
    
    protected function setUp(): void
    {
        $this->fraudChecker = new FraudCheckerTwoSDK();
        $this->transaction = $this->createMock(Transaction::class);
    }
    
    public function testConnectSuccess()
    {
        $result = $this->fraudChecker->connect(true);
    
        $this->assertEquals($result, true);
    }
    
    public function testConnectFailure()
    {
        $result = $this->fraudChecker->connect(false);
    
        $this->assertEquals($result, false);
    }

    /**
     * @dataProvider isAuthorizedSuccessProvider
     */
    public function testIsAuthorizedSuccess($simulateAuthorized, $expected)
    {
        $result = $this->fraudChecker->isAuthorized($this->transaction, $simulateAuthorized);

        $this->assertEquals($result, $expected);
    }

    public function isAuthorizedSuccessProvider(): array
    {
        return [
           'is authorized: connect:true, authorized:true ' => [
                'simulateAuthorized' => [
                    'connect' => true, 'authorized' => true
                ],
                'expected' => true,
            ]
        ];
    }

    /**
     * @dataProvider isAuthorizedFailureProvider
     */
    public function testIsAuthorizedFailure($simulateAuthorized, $expected)
    {
        $result = $this->fraudChecker->isAuthorized($this->transaction, $simulateAuthorized);

        $this->assertEquals($result, $expected);
    }

    public function isAuthorizedFailureProvider(): array
    {
        return [
           'not authorized: connect:false, authorized:false ' => [
                'simulateAuthorized' => [
                    'connect' => false, 'authorized' => false
                ],
                'expected' => false,
            ],

           'not authorized: connect:true, authorized:false ' => [
                'simulateAuthorized' => [
                    'connect' => true, 'authorized' => false
                ],
                'expected' => false,
            ]
        ];
    }
}
