<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use DateTime;

class Transaction
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var float
     */
    private float $initialAmount;

    /**
     * @var float
     */
    private float $sellerTax;

    /**
     * @var float
     */
    private float $slytherinPayTax;

    /**
     * @var float
     */
    private float $totalTax;

    /**
     * @var float
     */
    private float $totalAmount;

    /**
     * @var DateTime
     */
    private DateTime $createdDate;

    /**
     * @var Seller
     */
    private Seller $seller;

    /**
     * @var Buyer
     */
    private Buyer $buyer;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getInitialAmount(): float
    {
        return $this->initialAmount;
    }

    /**
     * @param float $initialAmount
     */
    public function setInitialAmount(float $initialAmount): void
    {
        $this->initialAmount = $initialAmount;
    }

    /**
     * @return float
     */
    public function getSellerTax(): float
    {
        return $this->sellerTax;
    }

    /**
     * @param float $sellerTax
     */
    public function setSellerTax(float $sellerTax): void
    {
        $this->sellerTax = $sellerTax;
    }

    /**
     * @return float
     */
    public function getSlytherinPayTax(): float
    {
        return $this->slytherinPayTax;
    }

    /**
     * @param float $slytherinPayTax
     */
    public function setSlytherinPayTax(float $slytherinPayTax): void
    {
        $this->slytherinPayTax = $slytherinPayTax;
    }

    /**
     * @return float
     */
    public function getTotalTax(): float
    {
        return $this->totalTax;
    }

    /**
     * @param float $totalTax
     */
    public function setTotalTax(float $totalTax): void
    {
        $this->totalTax = $totalTax;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     */
    public function setTotalAmount(float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDate(): DateTime
    {
        return $this->createdDate;
    }

    /**
     * @param DateTime $createdDate
     */
    public function setCreatedDate(DateTime $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @return Seller
     */
    public function getSeller(): Seller
    {
        return $this->seller;
    }

    /**
     * @param Seller $seller
     */
    public function setSeller(Seller $seller): void
    {
        $this->seller = $seller;
    }

    /**
     * @return Buyer
     */
    public function getBuyer(): Buyer
    {
        return $this->buyer;
    }

    /**
     * @param Buyer $buyer
     */
    public function setBuyer(Buyer $buyer): void
    {
        $this->buyer = $buyer;
    }
}
