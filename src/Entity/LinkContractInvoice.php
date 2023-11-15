<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LinkContractInvoice
 *
 * @ORM\Table(name="link_contract_invoice")
 * @ORM\Entity
 */
class LinkContractInvoice
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ContractId", type="integer", nullable=true)
     */
    private $contractid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="InvoiceId", type="integer", nullable=true)
     */
    private $invoiceid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractid(): ?int
    {
        return $this->contractid;
    }

    public function setContractid(?int $contractid): static
    {
        $this->contractid = $contractid;

        return $this;
    }

    public function getInvoiceid(): ?int
    {
        return $this->invoiceid;
    }

    public function setInvoiceid(?int $invoiceid): static
    {
        $this->invoiceid = $invoiceid;

        return $this;
    }


}
