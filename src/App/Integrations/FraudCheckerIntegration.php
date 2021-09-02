<?php

declare(strict_types=1);

namespace App\Integrations;

use App\Domain\Entities\Transaction;
use App\Domain\Clients\FraudCheckerClientAuthorizedInterface;
use Exception;

class FraudCheckerIntegration
{
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
     * @throws Exception
     */
    public function verifyAuthorized(Transaction $transaction): bool
    {
        try {
            return $this->getAuthorized($transaction);
        } catch (\Throwable $th) {
            $th = self::AUTHORIZED_FAILURE_MESSAGE;
            throw new Exception($th);
        }
    }

    /**
     * @param Transaction $transaction
     * @return bool
     */
    private function getAuthorized(Transaction $transaction): bool
    {
        return $this->checker->isAuthorized($transaction);
    }
}
