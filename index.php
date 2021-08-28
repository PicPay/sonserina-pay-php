<?php

include ('bootstrap.php');

$container = new App\Domain\Libraries\FraudChecker\FraudCheckerContainer();
$iterator = new App\Domain\Libraries\FraudChecker\FraudCheckerIterator();
$fraudChecker = new App\Domain\Services\FraudChecker($container, $iterator);

$transactionRepository = new \App\Domain\Repositories\TransactionRepository();
$taxManagerLibrary = new App\Domain\Libraries\TaxManagerLibrary();
$notifierLibrary = new App\Domain\Libraries\NotifierLibrary();
$notifierService = new \App\Domain\Services\Notifier($notifierLibrary);
$taxCalculator = new \App\Domain\Services\TaxCalculator($taxManagerLibrary);
$transaction = new App\Domain\Entities\Transaction();

$transaction->setBuyer(new \App\Domain\Entities\Buyer());
$transaction->setSellerTax(10);
$transaction->setInitialAmount(100);

$handler = (new App\Domain\Services\TransactionHandler(
                $transactionRepository,
                $taxCalculator,
                $fraudChecker,
                $notifierService
        ))->create($transaction);
