<?php

declare(strict_types=1);

namespace App\Integrations;

use App\Domain\Entities\Transaction;
use App\Domain\Contracts\FraudCheckerClientAuthorizedInterface;
use Exception;

class FraudCheckerIntegration
{
    protected const AUTHORIZED_FAILURE_MESSAGE = 'Falha no processo de Autorização';

    private $checker;

    public function __construct(FraudCheckerClientAuthorizedInterface $checker)
    {
        $this->checker = $checker;
    }

     /**
     * @param Transaction $transaction
     * @return bool
     * @throws Exception
     */
    public function verifyAuthorized(Transaction $transaction, array $simulateAuthorized): bool
    {
        try {
            return $this->checker->isAuthorized($transaction, $simulateAuthorized);
        } catch (\Throwable $th) {
            throw new Exception(self::AUTHORIZED_FAILURE_MESSAGE);
        }
    }
}
