<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Contracts\FraudCheckerClientInterface;

interface FraudCheckerVendorClientInterface extends FraudCheckerClientInterface
{

    public function isAuthorized(): bool;

    //public function notify(string $message, int $code): void;

    public function extractMessageResponse($response): string;
}
