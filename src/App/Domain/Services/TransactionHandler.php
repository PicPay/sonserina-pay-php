<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Contracts\TransactionRepositoryInterface;
use App\Domain\Entities\Notification;
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

    public function __construct(
            TransactionRepositoryInterface $repository,
            TaxCalculator $taxCalculator,
            FraudChecker $fraudChecker,
            Notifier $notifier
    )
    {
        $this->repository = $repository;
        $this->taxCalculator = $taxCalculator;
        $this->fraudChecker = $fraudChecker;
        $this->notifier = $notifier;
    }

    /**
     * @throws Exception
     */
    public function create(Transaction $transaction): Transaction
    {
        try {
            $this->check($transaction);

            $configuration = $this->calculate($transaction);

            $this->configure($transaction, $configuration);
            $this->save($transaction);
            $this->notify($transaction);

            $print = array_merge($configuration, ['status' => true, 'message' => 'ok']);
        } catch (\Exception $exc) {
            $print = ['status' => false, 'message' => $exc->getMessage()];
        }

        $this->print($print);

        return $transaction;
    }

    private function print($data, bool $print = false): void
    {
        echo '<pre>';
        ($print) ? print_r($data) : var_dump($data);
        echo '</pre>';
    }

    private function save(Transaction $transaction): void
    {
        $this->repository->save($transaction);
    }

    private function notify(Transaction $transaction): void
    {
        $notification = $this->notifier->getClient()->configure($transaction);

        $this->notifier->notify($notification);
    }

    private function check(Transaction $transaction): void
    {
        if (!$this->fraudChecker->check($transaction)) {
            throw new Exception("Failure of fraud verification rules.");
        }
    }

    private function calculate(Transaction $transaction): array
    {
        $sellerTax = $transaction->getSellerTax();

        $totalValueWithTax = $this->taxCalculator->calculate($transaction->getInitialAmount(), $sellerTax);

        $sonserinaPay = $transaction->getInitialAmount() + $sellerTax - $totalValueWithTax;
        $sonserinaPay = abs($sonserinaPay);

        $totalTax = $sellerTax + $sonserinaPay;

        return compact('sellerTax', 'totalValueWithTax', 'totalTax', 'sonserinaPay');
    }

    private function configure(Transaction $transaction, array $config): void
    {
        $transaction->setCreatedDate(new DateTime());
        $transaction->setTotalTax($config['totalTax']);
        $transaction->setSlytherinPayTax($config['sonserinaPay']);
        $transaction->setTotalAmount($config['totalValueWithTax']);
    }

}
