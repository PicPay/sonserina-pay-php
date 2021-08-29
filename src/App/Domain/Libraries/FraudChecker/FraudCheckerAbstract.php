<?php

namespace App\Domain\Libraries\FraudChecker;

abstract class FraudCheckerAbstract
{

    protected const AUTHORIZED_MESSAGE = 'Autorizado';
    protected const NOT_AUTHORIZED_MESSAGE = 'Não está autorizado';

    /**
     * @var array 
     */
    protected array $allowedMessages = [
        self::AUTHORIZED_MESSAGE
    ];

    /**
     * @var bool 
     */
    protected bool $status;

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return ($this->getStatus() === true);
    }

    /**
     * @param string $message
     * @param int $code
     * @return void
     */
    public function notify(string $message, int $code): void
    {
        //...
    }

    /**
     * @return bool
     */
    private function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return array
     */
    private function getAllowedMessages(): array
    {
        return $this->allowedMessages;
    }

    /**
     * @param string $message
     * @return void
     */
    private function setStatusByMessage(string $message): void
    {
        $this->status = (in_array($message, $this->getAllowedMessages()));
    }

    /**
     * @param type $response
     * @return void
     */
    protected function return($response): void
    {
        $message = $this->extractMessageResponse($response);

        $this->setStatusByMessage($message);
    }

}
