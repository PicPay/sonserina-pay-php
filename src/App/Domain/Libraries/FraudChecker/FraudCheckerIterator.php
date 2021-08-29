<?php

declare(strict_types=1);

namespace App\Domain\Libraries\FraudChecker;

class FraudCheckerIterator
{

    /**
     * @var int 
     */
    private int $checkerCounter;

    /**
     * @var int 
     */
    private int $listLength;

    /**
     * @var array 
     */
    private array $checkersList;

    public function __construct()
    {
        $this->checkerCounter = 0;
        $this->listLength = 0;
        $this->checkersList = array();
    }

    /**
     * @return bool
     */
    public function isLastChecker(): bool
    {
        return ($this->getListLength() == $this->checkerCounter);
    }

    /**
     * @return void
     */
    public function incrementCheckerCount(): void
    {
        $this->checkerCounter++;
    }

    /**
     * @return int
     */
    public function getListLength(): int
    {
        return $this->listLength;
    }

    /**
     * @param array $list
     * @return void
     */
    public function setCheckersList(array $list): void
    {
        $this->checkersList = $list;
        $this->listLength = count($list);
    }

}
