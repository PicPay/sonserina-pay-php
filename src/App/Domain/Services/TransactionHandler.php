<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Contracts\TransactionRepositoryInterface;
use App\Domain\Services\Transactions\SettingsTransaction;
use App\Domain\Services\Notifications\DispatcherNotification;
use DateTime;
use Exception;

class TransactionHandler
{
    /**
     * @var TransactionRepositoryInterface
     */
    private TransactionRepositoryInterface $repository;

    /**
     * @var TaxCalculator
     */
    private TaxCalculator $taxCalculator;

    /**
     * @var FraudChecker
     */
    private FraudChecker $fraudChecker;

    /**
     * @var DispatcherNotification
     */
    private DispatcherNotification $dispatcherNotify;
    
    /**
     * @var SettingsTransaction
     */
    private SettingsTransaction $settingsTransaction;

    /**
     * @var array
     */
    protected const SIMULATE_AUTHORIZED = [
        0 => ['connect' => true, 'authorized' => true],
        1 => ['connect' => true, 'authorized' => true],
    ];

    public function __construct(
        TransactionRepositoryInterface $repository,
        TaxCalculator $taxCalculator,
        FraudChecker $fraudChecker,
        DispatcherNotification $dispatcherNotify,
        SettingsTransaction $settingsTransaction
    ) {
    
        $this->repository = $repository;
        $this->taxCalculator = $taxCalculator;
        $this->fraudChecker = $fraudChecker;
        $this->dispatcherNotify = $dispatcherNotify;
        $this->settingsTransaction = $settingsTransaction;
    }

    /**
     * @throws Exception
     */
    public function create(Transaction $transaction, bool $orderReverse, array $simulateAuthorized = []): Transaction
    {
        $this->checkProcess($transaction, $orderReverse, $simulateAuthorized);
        $transactionTaxValues = $this->taxCalculator->transactionTaxValues($transaction);
        $this->settingsTransaction->setup($transaction, $transactionTaxValues);
        $this->repository->save($transaction);
        $this->dispatcherNotify->sendNotify($transaction);
        
        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @param bool $orderReverse
     * @param array $simulateAuthorized
     * @return void
     * @throws \Exception
     */
    private function checkProcess(Transaction $transaction, $orderReverse, $simulateAuthorized): void
    {
        if (empty($simulateAuthorized)) {
            $simulateAuthorized = self::SIMULATE_AUTHORIZED;
        }
        
        if (!$this->fraudChecker->check($transaction, $orderReverse, $simulateAuthorized)) {
            throw new \Exception('Unauthorized transaction');
        }
    }
}
