<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Libraries\FraudChecker\FraudCheckerContainer;
use App\Domain\Exceptions\FraudCheckerEmptyException;
use App\Domain\Contracts\FraudCheckerVendorClientInterface;
use App\Domain\Exceptions\FraudCheckerNotAuthorizedException;
use App\Domain\Libraries\FraudChecker\FraudCheckerIterator;

class FraudChecker
{

    private array $servicesConsultingList;

    public function __construct(FraudCheckerContainer $container, FraudCheckerIterator $iterator)
    {
        $this->servicesConsultingList = array();

        $this->dependencies = [
            'container' => $container,
            'iterator' => $iterator,
        ];
    }

    public function getIterator()
    {
        return $this->dependencies['iterator'];
    }

    public function getContainer()
    {
        return $this->dependencies['container'];
    }

    public function check(Transaction $transaction): bool
    {
        $list = $this->getServicesConsultingList();
                $this->getIterator()->setCheckersList($list);

        if (empty($list)) {
            throw new FraudCheckerEmptyException();
        }

        foreach ($list as $checker) {

            $this->getIterator()->incrementCheckerCount();
            $this->runCheckByChecker($checker, $transaction);

            if ($checker->isAuthorized()) {
                return true;
            }

            if ($this->getIterator()->isLastChecker()) {
                throw new FraudCheckerNotAuthorizedException();
            }
        }
    }

    private function getServicesConsultingList()
    {
        return $this->servicesConsultingList = $this->getContainer()->getServices();
    }

    private function runCheckByChecker(FraudCheckerVendorClientInterface $checker, Transaction $transaction)
    {
        try {
            $checker->check($transaction);
        } catch (\Exception $exc) {
            //$checker->notify($exc->getMessage(), $exc->getCode());
        }
    }

}
