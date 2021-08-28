<?php

declare(strict_types=1);

namespace App\Domain\Entities;

class Buyer
{

    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $email;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        //return $this->email;
        return 'joseph@phpcode.com';
    }

}
