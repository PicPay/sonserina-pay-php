<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Services\Transaction\TransactionChecker;
use App\Domain\Services\Transaction\TransactionCalculator;
use App\Domain\Services\Transaction\TransactionConfigurator;
use App\Domain\Services\Transaction\TransactionSaver;
use App\Domain\Services\Transaction\TransactionNotifier;

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

    /**
     * @param TransactionChecker $checker
     * @param TransactionCalculator $calculator
     * @param TransactionConfigurator $configurator
     * @param TransactionSaver $saver
     * @param TransactionNotifier $notifier
     */
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
     * @param Transaction $transaction
     * @return Transaction
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

        if (isset($_GET['print'])) {
            $this->print($print);
        }

        return $transaction;
    }

    /**
     * @param type $data
     * @param bool $print
     * @return void
     */
    private function print($data = null, bool $print = false): void
    {
        echo '<pre>';
        ($print !== false) ? print_r($data) : var_dump($data);
        echo '</pre>';
    }

}
