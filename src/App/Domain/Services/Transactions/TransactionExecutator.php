<?php

declare(strict_types=1);

namespace App\Domain\Services\Transactions;

use App\Domain\Entities\{Buyer, Seller, Transaction, Notification};
use App\Domain\Repositories\TransactionRepository;
use App\Domain\Services\Transactions\SettingsTransaction;
use App\Domain\Services\Notifications\{GenerateNotification, DispatcherNotification};
use App\Domain\Services\{TransactionHandler, Notifier, FraudChecker, TaxCalculator};
use App\Domain\Client\{TaxManagerClient, NotifierClient};

class TransactionExecutator
{
    private Buyer $buyer;
    
    private Seller $seller;

    private Transaction $transaction;

    private TransactionRepository $repository;
 
    private TaxManagerClient $taxManagerClient;
    
    private TaxCalculator $taxCalculator;
    
    private Notification $notification;
    
    private GenerateNotification $generateNotification;
    
    private NotifierClient $notifierClient;
    
    private Notifier $notifier;  
    
    private DispatcherNotification $dispatcherNotify;
    
    private FraudChecker $fraudChecker;
    
    private SettingsTransaction $settingsTransaction;
     
    /**
     * @param Transaction $transaction
     * @return void
     */
    public function setEmailBuyer(string $email): void
    {
        $this->buyer = new Buyer();
        $this->buyer->setEmail($email);
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmailSeller(string $email): void
    {
        $this->seller = new Seller();
        $this->seller->setEmail($email);
    }

    /**
     * @param float $sellerTax
     * @param float $initialAmount
     * @return void
     */
    public function setTransaction(float $sellerTax, float $initialAmount): void
    {
        $this->transaction = new Transaction();
        $this->transaction->setBuyer($this->buyer);
        $this->transaction->setSeller($this->seller);
        $this->transaction->setSellerTax($sellerTax);
        $this->transaction->setInitialAmount($initialAmount);
    }

    /**
     * @return void
     */
    public function instantiatesClasses(): void
    {
        $this->repository = new TransactionRepository();

        $this->taxManagerClient = new TaxManagerClient();
        $this->taxCalculator = new TaxCalculator($this->taxManagerClient);

        $this->notification = new Notification();
        $this->generateNotification = new GenerateNotification($this->notification);

        $this->notifierClient = new NotifierClient();
        $this->notifier = new Notifier($this->notifierClient);  
        $this->dispatcherNotify = new DispatcherNotification($this->notifier, $this->generateNotification);

        $this->fraudChecker = new FraudChecker();
        $this->settingsTransaction = new SettingsTransaction();
    }
    
    /**
     * @param bool $orderReverse
     * @param array $simulateAuthorized
     * @return void
     */
    public function transactionHandlerExecute(bool $orderReverse, array $simulateAuthorized): void
    {
        $transactionHandler = new TransactionHandler(
            $this->repository,
            $this->taxCalculator,
            $this->fraudChecker,
            $this->dispatcherNotify,
            $this->settingsTransaction
        );
        
        $transactionHandler->create($this->transaction, $orderReverse, $simulateAuthorized);

    }

    /**
     * @param bool $orderReverse
     * @param array $simulateAuthorized
     * @return TransactionHandler
     */
    public function getTransactionHandlerExecute(bool $orderReverse, array $simulateAuthorized): TransactionHandler
    {
        return  new TransactionHandler(
            $this->repository,
            $this->taxCalculator,
            $this->fraudChecker,
            $this->dispatcherNotify,
            $this->settingsTransaction
        );
    }

    /**
     * @return Transaction
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }
}
