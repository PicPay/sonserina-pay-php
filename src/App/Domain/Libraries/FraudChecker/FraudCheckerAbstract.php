<?php

namespace App\Domain\Libraries\FraudChecker;

abstract class FraudCheckerAbstract
{

    protected const AUTHORIZED_MESSAGE = 'Autorizado';
    protected const NOT_AUTHORIZED_MESSAGE = 'Não está autorizado';

    protected array $allowedMessages = [
        self::AUTHORIZED_MESSAGE
    ];
    
    private bool $status;

    public function isAuthorized(): bool
    {
        return ($this->getStatus() == true);
    }

    public function notify(string $message, int $code): void
    {
        //...
    }

    private function getStatus(): bool
    {
        return $this->status;
    }

    private function getAllowedMessages(): array
    {
        return $this->allowedMessages;
    }

    private function setStatusByMessage(string $message): void
    {
        $this->status = (in_array($message, $this->getAllowedMessages()));
    }

    protected function return($response)
    {
        $message = $this->extractMessageResponse($response);

        $this->setStatusByMessage($message);
    }

}
