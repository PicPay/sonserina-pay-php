<?php

declare(strict_types=1);

namespace App\Domain\Libraries\FraudChecker;

class FraudCheckerIterator
{

    private int $checkerCounter;
    private int $listLength;
    private array $checkersList;

    public function __construct()
    {
        $this->checkerCounter = 0;
        $this->listLength = 0;
        $this->checkersList = array();
    }

    public function isLastChecker()
    {
        return ($this->getListLength() == $this->checkerCounter);
    }

    public function incrementCheckerCount()
    {
        $this->checkerCounter++;
    }

    public function getListLength(): int
    {
        return $this->listLength;
    }

    public function setCheckersList(array $list)
    {
        $this->checkersList = $list;
        $this->listLength = count($list);
    }

}
