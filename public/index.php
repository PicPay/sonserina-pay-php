<?php

require __DIR__.'/../vendor/autoload.php';

use \App\Domain\Services\Transactions\TransactionExecutator;

$simulateAuthorized = [
    0 => ['connect' => true, 'authorized' => true],
    1 => ['connect' => true, 'authorized' => true],
];
$orderReverse = true;

$executator = new TransactionExecutator();
$executator->setEmailBuyer('buyer@gmail.com');
$executator->setEmailSeller('seller@gmail.com');
$executator->setTransaction(2, 20);

$executator->instantiatesClasses();

$executator->transactionHandlerExecute($orderReverse, $simulateAuthorized);