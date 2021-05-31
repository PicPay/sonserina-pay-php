<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Transaction;
use App\Domain\Repositories\TransactionRepositoryInterface;
use DateTime;
use Exception;

class TransactionHandler
{
    /**
     * @var TransactionRepositoryInterface
     */
    private TransactionRepositoryInterface $repository;

    /**
     * @var TaxCalculator
     */
    private TaxCalculator $taxCalculator;

    /**
     * @var FraudChecker
     */
    private FraudChecker $fraudChecker;

    /**
     * @var Notifier
     */
    private Notifier $notifier;

    public function __construct(
        TransactionRepositoryInterface $repository,
        TaxCalculator $taxCalculator,
        FraudChecker $fraudChecker,
        Notifier $notifier
    )
    {
        $this->repository = $repository;
        $this->taxCalculator = $taxCalculator;
        $this->fraudChecker = $fraudChecker;
        $this->notifier = $notifier;
    }

    /**
     * @throws Exception
     */
    public function create(Transaction $transaction): Transaction
    {
        /**
         * Draco: Aqui valida se pode fazer a transação, a Granger falou que tem uns chamados estranhos dizendo que
         * o cliente tá conseguindo sacar dinheiro da carteira do lojista, mas com certeza é culpa da empresa
         * que faz a analise anti fraude, eles são trouxas né? Meu sistema não pode fazer nada pra resolver isso.
         */
        if (!$this->fraudChecker->check($transaction)) {
            throw new Exception("Deu erro aqui.");
        }

        /**
         * Goyle: esse trecho de código calcula o valor total com a taxa do sonserinapay, pra saber o valor total da taxa tem
         * que calcular inicialAmount + sellerTaxa - valorTotalWithTax = taxaSonserinaPay
         * pra saber o total de taxas tem que somar a taxa do sonserinapay com a taxa do lojista
         * mas eu não sei pra que isso serve não, só fix o que o Draco me mandou fazer
         */
        $totalValueComTaxas = $this->taxCalculator->calculate($transaction->getInitialAmount(), $transaction->getSellerTax());

        /**
         * Draco: Salva a data de criação da transação
         */
        $transaction->setCreatedDate(new DateTime());

        /**
         * Draco: Era pra notificar o cliente e o lojista né? Mas esse cara tá dando problema, com certeza
         * é culpa do Crabbe que não fez a classe de notificação direito
         */
//        $this->notifier->notify($transaction);

        /**
         * Crabbe: Aqui salva a transação
         * Draco: As vezes a gente da erro na hora de salvar ai a gente já mandou notificação pro cliente, mas paciência né?
         */
        return $this->repository->save($transaction);
    }
}
