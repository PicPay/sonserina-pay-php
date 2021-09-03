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

    /**
     * @dataProvider checkSuccesProvider
     */
    public function testCheckSuccess($orderReverse, $simulateAuthorized, $expected)
    {
        $transaction = $this->createMock(Transaction::class);
        $result = $this->fraudChecker->check($transaction, $orderReverse, $simulateAuthorized);

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
                    0 => ['connect' => false, 'authorized' => true], 
                    1 => ['connect' => true, 'authorized' => true], 
                ],
                'expected' => true,
           ],
           'connect0 FALSE, authorized0 FALSE, connect1 TRUE, authorized1 TRUE, reverse TRUE' => [
                'orderReverse' => true,
                'simulateAuthorized' => [
                    0 => ['connect' => false, 'authorized' => true], 
                    1 => ['connect' => true, 'authorized' => true], 
                ],
                'expected' => true,
            ],
        ];
    }
}
