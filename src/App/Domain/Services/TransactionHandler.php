<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Repositories\TransactionRepositoryInterface;
use App\Domain\Services\Transactions\TransactionSettings;
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
     * @var Notifier
     */
    private Notifier $notifier;
    
    /**
     * @var TransactionSettings
     */
    private TransactionSettings $transactionSettings;

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
        Notifier $notifier,
        TransactionSettings $transactionSettings
    ) {
    
        $this->repository = $repository;
        $this->taxCalculator = $taxCalculator;
        $this->fraudChecker = $fraudChecker;
        $this->notifier = $notifier;
        $this->transactionSettings = $transactionSettings;
    }

    /**
     * @throws Exception
     */
    public function create(Transaction $transaction, bool $orderReverse, array $simulateAuthorized = []): Transaction
    {
        try {
            $this->checkProcess($transaction, $orderReverse, $simulateAuthorized);
            $transactionTaxValues = $this->taxCalculator->transactionTaxValues($transaction);
            $this->transactionSettings->setup($transaction, $transactionTaxValues);
            $this->repository->save($transaction);
            $this->notifier->notify($transaction);
            
            return $transaction;
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
        

       

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
            throw new \Exception('Fraud detected in transaction');
        }
    }
}
