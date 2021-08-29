<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use App\Domain\Exceptions\FraudCheckerException;

class FraudCheckerEmptyException extends FraudCheckerException
{

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     */
    public function __construct(
            string $message = 'There are no anti-fraud checkers to proceed with the transaction',
            int $code = 0,
            \Throwable $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }

}
