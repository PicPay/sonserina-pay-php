<?php

declare(strict_types=1);

namespace Unit\Domain\Services;

use App\Domain\Entities\{Buyer, Seller, Transaction, Notification};
use App\Domain\Repositories\TransactionRepository;
use App\Domain\Services\Transactions\SettingsTransaction;
use App\Domain\Services\Notifications\{GenerateNotification, DispatcherNotification};
use App\Domain\Services\{TransactionHandler, Notifier, FraudChecker, TaxCalculator};
use App\Domain\Client\{TaxManagerClient, NotifierClient};
use \App\Domain\Services\Transactions\TransactionExecutator;

use PHPUnit\Framework\TestCase;

class TransactionHandlerTest extends TestCase
{
    private TransactionExecutator $executator;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->executator = new TransactionExecutator();
        
    }

    /**
     * @dataProvider createSuccessProvider
     */
    public function testCreateSuccess($simulateAuthorized, $executatorData, $orderReverse, $expected)
    {
        $this->executator->setEmailBuyer($executatorData['emailBuyer']);
        $this->executator->setEmailSeller($executatorData['emailSeller']);
        $this->executator->setTransaction($executatorData['transaction'][0],$executatorData['transaction'][1]);
        
        $this->executator->instantiatesClasses();
        $this->transaction =  $this->executator->getTransaction();

        $handler = $this->executator->getTransactionHandlerExecute($orderReverse, $simulateAuthorized);
        $handler->create($this->transaction, $orderReverse, $simulateAuthorized);
    
        $this->assertEquals(true, $this->transaction->getStatus());

    }


    public function createSuccessProvider(): array
    {
        return [
            'test succsses' => [
                'simulateAuthorized' => [
                    0 => ['connect' => true, 'authorized' => true],
                    1 => ['connect' => true, 'authorized' => true],
                ],
                'executatorData' => [
                    'emailBuyer' => 'buyer@gmail.com',
                    'emailSeller' => 'seller@gmail.com',
                    'transaction' => [2, 20]
                ],
                'orderReverse' => true,
                'expected' => true,
            ],
            'test succsses - empty simulateAuthorized' => [
                'simulateAuthorized' => [],
                'executatorData' => [
                    'emailBuyer' => 'buyer@gmail.com',
                    'emailSeller' => 'seller@gmail.com',
                    'transaction' => [2, 20]
                ],
                'orderReverse' => true,
                'expected' => true,
            ]
        ];
    }


    /**
     * @dataProvider createFailureProvider
     */
    public function testCreateFailure($simulateAuthorized, $executatorData, $orderReverse, $expected)
    {
        $this->executator->setEmailBuyer($executatorData['emailBuyer']);
        $this->executator->setEmailSeller($executatorData['emailSeller']);
        $this->executator->setTransaction($executatorData['transaction'][0],$executatorData['transaction'][1]);
        
        $this->executator->instantiatesClasses();
        $this->transaction =  $this->executator->getTransaction();

        $handler = $this->executator->getTransactionHandlerExecute($orderReverse, $simulateAuthorized);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($expected);

        $handler->create($this->transaction, $orderReverse, $simulateAuthorized);
    
    

    }


    public function createFailureProvider(): array
    {
        return [
            'test exception' => [
                'simulateAuthorized' => [
                    0 => ['connect' => true, 'authorized' => false],
                    1 => ['connect' => true, 'authorized' => false],
                ],
                'executatorData' => [
                    'emailBuyer' => 'buyer@gmail.com',
                    'emailSeller' => 'seller@gmail.com',
                    'transaction' => [2, 20]
                ],
                'orderReverse' => true,
                'expected' => 'Failure to process Transaction',
            ]
        ];
    }

}
