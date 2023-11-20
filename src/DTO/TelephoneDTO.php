<?php

namespace App\DTO;

use App\Entity\Contracts;
use App\Entity\Telephone;

class TelephoneDTO
{
    /**
     * @var Telephone|null
     */
    private $telephone;

    /**
     * @var Contracts|null
     */
    public $contrat;

    /**
     * @return Telephone|null
     */
    public function getTelephone(): ?Telephone
    {
        return $this->telephone;
    }

    /**
     * @param Telephone $telephone
     * @return TelephoneDTO
     */
    public function setTelephone(Telephone $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }


    public function getContrat(): ?Contracts
    {
        return $this->contrat;
    }

    /**
     * @param Contracts $contrat
     * @return TelephoneDTO
     */
    public function setContrat(Contracts $contrat): self
    {
        $this->contrat = $contrat;
        return $this;
    }



}
