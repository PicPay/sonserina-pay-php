<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;

class FraudChecker
{
    public function check(Transaction $transaction, bool $firstFirst): bool
    {
        if(!isValid($transaction)) return false;

        if($firstFirst) {
            $url1 = '';
            $url2 = '';
        } else {
            $url1 = '';
            $url2 = '';
        }

        return (getClient($url1) == "Autorizado" || getClient($url2) == "Autorizado");
    }

    public function getClient(string $request_url): string
    {
        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        
        $response = json_decode($response, true);
        return $response["message"];
    }

    public function isValid(Transaction $transaction): bool
    {
        return ($transaction->getTotalAmount() > 0);
    }
}
