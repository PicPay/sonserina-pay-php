<?php

include ('bootstrap.php');

$frauCheckerContainerLibrary = new App\Domain\Libraries\FraudChecker\FraudCheckerContainer();
$frauCheckerIteratorLibrary = new App\Domain\Libraries\FraudChecker\FraudCheckerIterator();
$fraudCheckerService = new App\Domain\Services\FraudChecker($frauCheckerContainerLibrary, $frauCheckerIteratorLibrary);

$taxManagerLibrary = new App\Domain\Libraries\TaxManagerLibrary();
$notifierLibrary = new App\Domain\Libraries\NotifierLibrary();

$notifierService = new \App\Domain\Services\Notifier($notifierLibrary);
$taxCalculatorService = new \App\Domain\Services\TaxCalculator($taxManagerLibrary);
$transactionRepository = new \App\Domain\Repositories\TransactionRepository();

$transactionCalculator = new App\Domain\Services\Transaction\TransactionCalculator($taxCalculatorService);
$transactionChecker = new App\Domain\Services\Transaction\TransactionChecker($fraudCheckerService);
$transactionConfigurator = new App\Domain\Services\Transaction\TransactionConfigurator();
$transactionNotifier = new App\Domain\Services\Transaction\TransactionNotifier($notifierService);
$transactionSaver = new App\Domain\Services\Transaction\TransactionSaver($transactionRepository);

$transaction = new App\Domain\Entities\Transaction();
$transaction->setBuyer(new \App\Domain\Entities\Buyer());
$transaction->setSellerTax(10);
$transaction->setInitialAmount(100);

$handler = (new App\Domain\Services\TransactionHandler(
                $transactionChecker,
                $transactionCalculator,
                $transactionConfigurator,
                $transactionSaver,
                $transactionNotifier
        ))->create($transaction);
