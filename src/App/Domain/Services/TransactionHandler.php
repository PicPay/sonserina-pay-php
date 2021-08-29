<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Services\Transaction\TransactionChecker;
use App\Domain\Services\Transaction\TransactionCalculator;
use App\Domain\Services\Transaction\TransactionConfigurator;
use App\Domain\Services\Transaction\TransactionSaver;
use App\Domain\Services\Transaction\TransactionNotifier;
use Exception;

class TransactionHandler
{

    /**
     * @var TransactionChecker
     */
    private TransactionChecker $checker;

    /**
     * @var TransactionCalculator
     */
    private TransactionCalculator $calculator;

    /**
     * @var TransactionConfigurator
     */
    private TransactionConfigurator $configurator;

    /**
     * @var TransactionSaver
     */
    private TransactionSaver $saver;

    /**
     * @var TransactionNotifier
     */
    private TransactionNotifier $notifier;

    public function __construct(
            TransactionChecker $checker,
            TransactionCalculator $calculator,
            TransactionConfigurator $configurator,
            TransactionSaver $saver,
            TransactionNotifier $notifier
    )
    {
        $this->checker = $checker;
        $this->calculator = $calculator;
        $this->configurator = $configurator;
        $this->saver = $saver;
        $this->notifier = $notifier;
    }

    /**
     * @throws Exception
     */
    public function create(Transaction $transaction): Transaction
    {
        try {
            $this->checker->process($transaction);

            $configuration = $this->calculator->process($transaction);
            $this->configurator->process($transaction, $configuration);

            $this->saver->process($transaction);
            $this->notifier->process($transaction);

            $print = array_merge($configuration, ['status' => true, 'message' => 'Okay']);
        } catch (\Exception $exc) {
            $print = ['status' => false, 'message' => $exc->getMessage()];
        }

        //$this->print($print);

        return $transaction;
    }

    private function print($data, bool $print = false): void
    {
        echo '<pre>';
        ($print) ? print_r($data) : var_dump($data);
        echo '</pre>';
    }

}
