<?php

declare(strict_types=1);

namespace App\Infra\FraudCheckers;

use App\Domain\Clients\FraudCheckerClientAuthorizedInterface;
use App\Domain\Entities\Transaction;
use Exception;

class FraudCheckerTwoSDK implements FraudCheckerClientAuthorizedInterface
{
    protected const NOT_AUTHORIZED_MESSAGE = 'Não está autorizado';
    protected const AUTHORIZED_MESSAGE = 'Autorizado';
    protected const CONNECTION_FAILURE_MESSAGE = 'Falha de Conexão';

    /**
     * @param bool $params
     * @return bool
     * @throws Exception
    */
    public function connect(bool $params):bool
    {
        try {
            return $params;
        } catch (\Throwable $th) {
            throw new Exception(self::CONNECTION_FAILURE_MESSAGE);
        }
    }

    /**
     * @param Transaction $transaction
     * @return bool
     */
    public function isAuthorized(Transaction $transaction, array $simulateAuthorized): bool
    {
        $connect = $this->connect($simulateAuthorized['connect']);
        
        if (!$connect) {
            return false;
        }
        
        $authorizedMessage = $this->authorizedMessage($transaction, $simulateAuthorized['authorized']);
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
