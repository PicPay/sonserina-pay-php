<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Libraries\FraudChecker\FraudCheckerContainer;
use App\Domain\Exceptions\FraudCheckerEmptyException;
use App\Domain\Exceptions\FraudCheckerNotAuthorizedException;
use App\Domain\Libraries\FraudChecker\FraudCheckerIterator;

class FraudChecker
{

    /**
     * @var array 
     */
    private array $servicesConsultingList;

    /**
     * @param FraudCheckerContainer $container
     * @param FraudCheckerIterator $iterator
     */
    public function __construct(FraudCheckerContainer $container, FraudCheckerIterator $iterator)
    {
        $this->servicesConsultingList = array();

        $this->dependencies = [
            'container' => $container,
            'iterator' => $iterator,
        ];
    }

    /**
     * @return FraudCheckerIterator
     */
    public function getIterator(): FraudCheckerIterator
    {
        return $this->dependencies['iterator'];
    }

    /**
     * @return FraudCheckerContainer
     */
    public function getContainer(): FraudCheckerContainer
    {
        return $this->dependencies['container'];
    }

    /**
     * @param Transaction $transaction
     * @return bool
     * @throws FraudCheckerEmptyException
     * @throws FraudCheckerNotAuthorizedException
     */
    public function check(Transaction $transaction): bool
    {
        $list = $this->getServicesConsultingList();
        $this->getIterator()->setCheckersList($list);

        if (empty($list)) {
            throw new FraudCheckerEmptyException();
        }

        foreach ($list as $checker) {

            $this->getIterator()->incrementCheckerCount();

            $checker->check($transaction);
            if ($checker->isAuthorized()) {
                return true;
            }

            if ($this->getIterator()->isLastChecker()) {
                throw new FraudCheckerNotAuthorizedException();
            }
        }
    }

    /**
     * @return array
     */
    private function getServicesConsultingList(): array
    {
        return $this->servicesConsultingList = $this->getContainer()->getServices();
    }

}
