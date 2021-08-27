<?php

include ('bootstrap.php');

$container = new App\Domain\Libraries\FraudChecker\FraudCheckerContainer();
$iterator = new App\Domain\Libraries\FraudChecker\FraudCheckerIterator();
$fraudChecker = new App\Domain\Services\FraudChecker($container, $iterator);

$transactionRepository = new \App\Domain\Repositories\TransactionRepository();
$taxManager = new App\Domain\Libraries\TaxManagerLibrary();
$notifierLibrary = new App\Domain\Libraries\NotifierLibrary();
$notifierService = new \App\Domain\Services\Notifier($notifierLibrary);
$taxCalculator = new \App\Domain\Services\TaxCalculator($taxManager);
$transaction = new App\Domain\Entities\Transaction();

$handler = (new App\Domain\Services\TransactionHandler(
                $transactionRepository,
                $taxCalculator,
                $fraudChecker,
                $notifierService
        ))->create($transaction);
