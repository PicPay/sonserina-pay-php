<?php

declare(strict_types=1);

namespace App\Infra\Integrations;

use App\Domain\Entities\Transaction;
use App\Domain\Clients\FraudCheckerClientAuthorizedInterface;
use Exception;

class FraudCheckerIntegration
{
    protected const NOT_AUTHORIZED_MESSAGE = 'Não está autorizado';
    protected const AUTHORIZED_MESSAGE = 'Autorizado';
    protected const CONNECTION_FAILURE_MESSAGE = 'Falha de Conexão';
    protected const AUTHORIZED_FAILURE_MESSAGE = 'Falha no processo de Autorização';

    private $checker;

    public function __construct(FraudCheckerClientAuthorizedInterface $checker)
    {
        $this->checker = $checker;
    }

    /**
     * @param bool $param
     * @return bool
     * @throws Exception
     */
    public function verifyConnect(bool $params): bool
    {
        try {
            return $this->getConnect($params);
        } catch (\Throwable $th) {
            $th = $this->CONNECTION_FAILURE;
            throw new Exception($th);
        }
    }

    /**
     * @param bool $param
     * @return bool
     */
    private function getConnect(bool $params): bool
    {
        return $this->checker->connect($params);
    }

    /**
     * @param Transaction $transaction
     * @return bool
     */
    public function isAuthorized(Transaction $transaction): bool
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
    private function authorizedMessage(Transaction $transaction): string
    {
        $response = $this->verifyAuthorized($transaction);

        if (!$response) {
            return self::NOT_AUTHORIZED_MESSAGE;
        }

        return self::AUTHORIZED_MESSAGE;
    }

     /**
     * @param Transaction $transaction
     * @return bool
     * @throws Exception
     */
    private function verifyAuthorized(Transaction $transaction): bool
    {
        try {
            return $this->getCheck($transaction);
        } catch (\Throwable $th) {
            $th = self::AUTHORIZED_FAILURE_MESSAGE;
            throw new Exception($th);
        }
    }

    private function getCheck(Transaction $transaction): bool
    {
        return $this->checker->check($transaction);
    }
}
