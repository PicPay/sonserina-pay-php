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

        $this->checkProcess($transaction, $orderReverse, $simulateAuthorized);

        $transactionTaxValues = $this->taxCalculator->transactionTaxValues($transaction);
        $this->transactionSettings->setup($transaction, $transactionTaxValues);
        

       

        /**
         * Draco: Era pra notificar o cliente e o lojista né? Mas esse cara tá dando problema, com certeza
         * é culpa do Crabbe que não fez a classe de notificação direito
         */
//        $this->notifier->notify($transaction);

        /**
         * Crabbe: Aqui salva a transação
         * Draco: As vezes a gente da erro na hora de salvar ai a gente já mandou notificação pro cliente, mas paciência né?
         */
        return $this->repository->save($transaction);
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
