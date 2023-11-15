<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="action")
 * @ORM\Entity
 */
class Action
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="IdAction", type="integer")
     */
    private $idaction;

    /**
     * @ORM\Column(name="UserIdAction", type="integer", nullable=true)
     */
    private $useridaction;

    /**
     * @ORM\Column(name="CodeAction", type="integer", nullable=true)
     */
    private $codeaction;

    /**
     * @ORM\Column(name="MessageAction", type="text", length=65535, nullable=true)
     */
    private $messageaction;

    /**
     * @ORM\Column(name="CreatedAction", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdaction;

    /**
     * @ORM\Column(name="UpdatedAction", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedaction;

    /**
     * @ORM\Column(name="DeletedAction", type="datetime", nullable=true)
     */
    private $deletedaction;

    /**
     * @ORM\Column(name="TiersIDAction", type="integer", nullable=true)
     */
    private $tiersidaction;

    /**
     * @ORM\Column(name="ProduitIDAction", type="integer", nullable=true)
     */
    private $produitidaction;

    /**
     * @ORM\Column(name="GrhIDAction", type="integer", nullable=true)
     */
    private $grhidaction;

    /**
     * @ORM\Column(name="ChantierIDAction", type="integer", nullable=true)
     */
    private $chantieridaction;

    /**
     * @ORM\Column(name="DevisIDAction", type="integer", nullable=true)
     */
    private $devisidaction;

    /**
     * @ORM\Column(name="CommandeIDAction", type="integer", nullable=true)
     */
    private $commandeidaction;

    /**
     * @ORM\Column(name="FactureIDAction", type="integer", nullable=true)
     */
    private $factureidaction;

    /**
     * @ORM\Column(name="DevisSupplierIDAction", type="integer", nullable=true)
     */
    private $devissupplieridaction;

    /**
     * @ORM\Column(name="CommandeSupplierIDAction", type="integer", nullable=true)
     */
    private $commandesupplieridaction;

    /**
     * @ORM\Column(name="FactureSupplierIDAction", type="integer", nullable=true)
     */
    private $facturesupplieridaction;

    /**
     * @ORM\Column(name="InterventionSupplierIDAction", type="integer", nullable=true)
     */
    private $interventionsupplieridaction;

    /**
     * @ORM\Column(name="InterventionTypeSupplierIDAction", type="integer", nullable=true)
     */
    private $interventiontypesupplieridaction;

    /**
     * @ORM\Column(name="DocumentIDAction", type="integer", nullable=true)
     */
    private $documentidaction;

    public function getIdaction(): ?int
    {
        return $this->idaction;
    }

    public function getUseridaction(): ?int
    {
        return $this->useridaction;
    }

    public function setUseridaction(?int $useridaction): static
    {
        $this->useridaction = $useridaction;

        return $this;
    }

    public function getCodeaction(): ?int
    {
        return $this->codeaction;
    }

    public function setCodeaction(?int $codeaction): static
    {
        $this->codeaction = $codeaction;

        return $this;
    }

    public function getMessageaction(): ?string
    {
        return $this->messageaction;
    }

    public function setMessageaction(?string $messageaction): static
    {
        $this->messageaction = $messageaction;

        return $this;
    }

    public function getCreatedaction(): ?\DateTimeInterface
    {
        return $this->createdaction;
    }

    public function setCreatedaction(?\DateTimeInterface $createdaction): static
    {
        $this->createdaction = $createdaction;

        return $this;
    }

    public function getUpdatedaction(): ?\DateTimeInterface
    {
        return $this->updatedaction;
    }

    public function setUpdatedaction(?\DateTimeInterface $updatedaction): static
    {
        $this->updatedaction = $updatedaction;

        return $this;
    }

    public function getDeletedaction(): ?\DateTimeInterface
    {
        return $this->deletedaction;
    }

    public function setDeletedaction(?\DateTimeInterface $deletedaction): static
    {
        $this->deletedaction = $deletedaction;

        return $this;
    }

    public function getTiersidaction(): ?int
    {
        return $this->tiersidaction;
    }

    public function setTiersidaction(?int $tiersidaction): static
    {
        $this->tiersidaction = $tiersidaction;

        return $this;
    }

    public function getProduitidaction(): ?int
    {
        return $this->produitidaction;
    }

    public function setProduitidaction(?int $produitidaction): static
    {
        $this->produitidaction = $produitidaction;

        return $this;
    }

    public function getGrhidaction(): ?int
    {
        return $this->grhidaction;
    }

    public function setGrhidaction(?int $grhidaction): static
    {
        $this->grhidaction = $grhidaction;

        return $this;
    }

    public function getChantieridaction(): ?int
    {
        return $this->chantieridaction;
    }

    public function setChantieridaction(?int $chantieridaction): static
    {
        $this->chantieridaction = $chantieridaction;

        return $this;
    }

    public function getDevisidaction(): ?int
    {
        return $this->devisidaction;
    }

    public function setDevisidaction(?int $devisidaction): static
    {
        $this->devisidaction = $devisidaction;

        return $this;
    }

    public function getCommandeidaction(): ?int
    {
        return $this->commandeidaction;
    }

    public function setCommandeidaction(?int $commandeidaction): static
    {
        $this->commandeidaction = $commandeidaction;

        return $this;
    }

    public function getFactureidaction(): ?int
    {
        return $this->factureidaction;
    }

    public function setFactureidaction(?int $factureidaction): static
    {
        $this->factureidaction = $factureidaction;

        return $this;
    }

    public function getDevissupplieridaction(): ?int
    {
        return $this->devissupplieridaction;
    }

    public function setDevissupplieridaction(?int $devissupplieridaction): static
    {
        $this->devissupplieridaction = $devissupplieridaction;

        return $this;
    }

    public function getCommandesupplieridaction(): ?int
    {
        return $this->commandesupplieridaction;
    }

    public function setCommandesupplieridaction(?int $commandesupplieridaction): static
    {
        $this->commandesupplieridaction = $commandesupplieridaction;

        return $this;
    }

    public function getFacturesupplieridaction(): ?int
    {
        return $this->facturesupplieridaction;
    }

    public function setFacturesupplieridaction(?int $facturesupplieridaction): static
    {
        $this->facturesupplieridaction = $facturesupplieridaction;

        return $this;
    }

    public function getInterventionsupplieridaction(): ?int
    {
        return $this->interventionsupplieridaction;
    }

    public function setInterventionsupplieridaction(?int $interventionsupplieridaction): static
    {
        $this->interventionsupplieridaction = $interventionsupplieridaction;

        return $this;
    }

    public function getInterventiontypesupplieridaction(): ?int
    {
        return $this->interventiontypesupplieridaction;
    }

    public function setInterventiontypesupplieridaction(?int $interventiontypesupplieridaction): static
    {
        $this->interventiontypesupplieridaction = $interventiontypesupplieridaction;

        return $this;
    }

    public function getDocumentidaction(): ?int
    {
        return $this->documentidaction;
    }

    public function setDocumentidaction(?int $documentidaction): static
    {
        $this->documentidaction = $documentidaction;

        return $this;
    }
}
