<?php

require __DIR__.'/../vendor/autoload.php';

use \App\Domain\Entities\{Buyer, Seller};

$buyer = new Buyer();
$seller = new Seller();
$buyer->setEmail('wellingtonlogia@gmail.com');
$seller->setEmail('wellallencar@gmail.com');
var_dump($buyer);
var_dump($seller);
