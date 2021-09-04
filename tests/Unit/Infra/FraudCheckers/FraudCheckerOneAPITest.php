<?php

declare(strict_types=1);

namespace Unit\Infra\FraudCheckers;

use App\Infra\FraudCheckers\FraudCheckerOneAPI;
use App\Domain\Entities\Transaction;
use PHPUnit\Framework\TestCase;

class FraudCheckerOneAPITest extends TestCase
{
    private $fraudCheckerClient;
    private $transaction;

    private const NOT_AUTHORIZED_MESSAGE = 'Não está autorizado';
    private const AUTHORIZED_MESSAGE = 'Autorizado';
    
    protected function setUp(): void
    {
        $this->fraudCheckerClient = new FraudCheckerOneAPI();
        $this->transaction = $this->createMock(Transaction::class);
    }
    
    public function testConnectSuccess()
    {
        $result = $this->fraudCheckerClient->connect(true);
    
        $this->assertEquals($result, true);
    }
    
    public function testConnectFailure()
    {
        $result = $this->fraudCheckerClient->connect(false);
    
        $this->assertEquals($result, false);
    }

    /**
     * @dataProvider isAuthorizedSuccessProvider
     */
    public function testIsAuthorizedSuccess($simulateAuthorized, $expected)
    {
        $result = $this->fraudCheckerClient->isAuthorized($this->transaction, $simulateAuthorized);

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
        $result = $this->fraudCheckerClient->isAuthorized($this->transaction, $simulateAuthorized);

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


    /**
     * @dataProvider authorizedMessageProvider
     */
    public function testAuthorizedMessage($simulateAuthorized, $expected)
    {
        $params = [$this->transaction, $simulateAuthorized];
        $result = $this->getMethod($this->fraudCheckerClient, 'authorizedMessage', $params);

        $this->assertEquals($result, $expected);
    }

    public function authorizedMessageProvider(): array
    {
        return [
           'is authorized' => [
                'simulateAuthorized' => true,
                'expected' => self::AUTHORIZED_MESSAGE,
           ],
           'not authorized' => [
                'simulateAuthorized' => false,
                'expected' => self::NOT_AUTHORIZED_MESSAGE,
           ],
           
        ];
    }

    private function getMethod(object $class, string $method, array $parameters = [])
    {
        $classRefletion = (new \ReflectionClass($class));
        $method = $classRefletion->getMethod($method);
        $method->setAccessible(true);
       
        return $method->invokeArgs($class, $parameters);
    }
}
