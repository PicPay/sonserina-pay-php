<?php

require __DIR__.'/../vendor/autoload.php';

use \App\Domain\Entities\{Buyer, Seller, Transaction, Notification};
use \App\Domain\Services\TransactionHandler;
use \App\Domain\Repositories\TransactionRepository;
use \App\Domain\Services\Transactions\SettingsTransaction;
use \App\Domain\Services\Notifications\{GenerateNotification, DispatcherNotification};
use \App\Domain\Services\{Notifier, FraudChecker, TaxCalculator};
use \App\Domain\Dale\{TaxManagerClient, NotifierClient};


$buyer = new Buyer();
$seller = new Seller();
$buyer->setEmail('buyer@gmail.com');
$seller->setEmail('seller@gmail.com');

$transaction = new Transaction();
$transaction->setBuyer($buyer);
$transaction->setSeller($seller);
$transaction->setSellerTax(2);
$transaction->setInitialAmount(20);

$repository = new TransactionRepository();

$taxManagerClient = new TaxManagerClient();
$taxCalculator = new TaxCalculator($taxManagerClient);

$notification = new Notification();
$generateNotification = new GenerateNotification($notification);

$notifierClient = new NotifierClient();
$notifier = new Notifier($notifierClient);  
$dispatcherNotify = new DispatcherNotification($notifier, $generateNotification);


$fraudChecker = new FraudChecker();
$settingsTransaction = new SettingsTransaction();

$simulateAuthorized = [
    0 => ['connect' => true, 'authorized' => true],
    1 => ['connect' => true, 'authorized' => true],
];

$orderReverse = true;

$transactionHandler = new TransactionHandler(
    $repository,
    $taxCalculator,
    $fraudChecker,
    $dispatcherNotify,
    $settingsTransaction
);

$transactionHandler->create($transaction, $orderReverse, $simulateAuthorized);