<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use App\Domain\Exceptions\FraudCheckerException;

class FraudCheckerNotAuthorizedException extends FraudCheckerException
{

    public function __construct(
            string $message = 'The anti-fraud check did not authorize a transaction',
            int $code = 0,
            \Throwable $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }

}
