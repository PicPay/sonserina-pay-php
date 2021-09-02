<?php

declare(strict_types=1);

namespace App\Infra\FraudCheckers;

use App\Domain\Clients\FraudCheckerClientAuthorizedInterface;
use App\Domain\Entities\Transaction;

class FraudCheckerOneAPI implements FraudCheckerClientAuthorizedInterface
{
    protected const NOT_AUTHORIZED_MESSAGE = 'Não está autorizado';
    protected const AUTHORIZED_MESSAGE = 'Autorizado';

    /**
     * @param bool $params
     * @return bool
    */
    public function connect(bool $params):bool
    {
        return $params;
    }

    /**
     * @param Transaction $transaction
     * @return bool
     */
    public function isAuthorized(Transaction $transaction,  bool $simulateAuthorized = true): bool
    {
        $authorizedMessage = $this->authorizedMessage($transaction);

        if ($authorizedMessage == self::NOT_AUTHORIZED_MESSAGE) {
            return false;
        }

        return true;
    }

    /**
     * @param Transaction $transaction
     * @return string
    */
    private function authorizedMessage(Transaction $transaction, bool $simulateAuthorized = true): string
    {
        if (!$simulateAuthorized) {
            return self::NOT_AUTHORIZED_MESSAGE;
        }

        return self::AUTHORIZED_MESSAGE;
    }

}
