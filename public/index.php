<?php

require __DIR__.'/../vendor/autoload.php';

use \App\Domain\Entities\{Buyer, Seller, Transaction};
use \App\Domain\Services\TransactionHandler;
use \App\Domain\Repositories\TransactionRepositoryInterface;
use \App\Domain\Services\Transactions\SettingsTransaction;
use \App\Domain\Services\Notifications\DispatcherNotification;
use \App\Domain\Services\FraudChecker;
use \App\Domain\Services\TaxCalculator;

$buyer = new Buyer();
$seller = new Seller();
$buyer->setEmail('wellingtonlogia@gmail.com');
$seller->setEmail('wellallencar@gmail.com');

$transaction = new Transaction();
$transaction->setBuyer($buyer);
$transaction->setSeller($seller);
$transaction->setSellerTax(2);
$transaction->setInitialAmount(20);


$repository = new TransactionRepositoryInterface();
$taxCalculator = new TaxCalculator();
$fraudChecker = new FraudChecker();
$dispatcherNotify = new DispatcherNotification();
$SettingsTransaction = new SettingsTransaction();

$simulateAuthorized = [
    0 => ['connect' => true, 'authorized' => true],
    1 => ['connect' => true, 'authorized' => true],
];

$orderReverse = false;

$transactionHandler = new TransactionHandler(
    $repository,
    $taxCalculator,
    $fraudChecker,
    $dispatcherNotify,
    $settingsTransaction
);

$transactionHandler->create($transaction, $orderReverse, $simulateAuthorized);
