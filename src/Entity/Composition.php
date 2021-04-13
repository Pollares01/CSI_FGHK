<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Composition
 *
 * @ORM\Table(name="composition", indexes={@ORM\Index(name="IDX_C7F4347D478C372", columns={"comp_idlot"}), @ORM\Index(name="IDX_C7F434718EC9469", columns={"comp_idproduit"})})
 * @ORM\Entity(repositoryClass="App\Repository\CompositionRepository")
 */
class Composition
{
    /**
     * @return int
     */
    public function getCompId(): int
    {
        return $this->compId;
    }

    /**
     * @param int $compId
     */
    public function setCompId(int $compId): void
    {
        $this->compId = $compId;
    }

    /**
     * @return int
     */
    public function getCompQuantite(): int
    {
        return $this->compQuantite;
    }

    /**
     * @param int $compQuantite
     */
    public function setCompQuantite(int $compQuantite): void
    {
        $this->compQuantite = $compQuantite;
    }

    /**
     * @return \Lot
     */
    public function getCompIdlot(): \Lot
    {
        return $this->compIdlot;
    }

    /**
     * @param Lot $compIdlot
     */
    public function setCompIdlot(Lot $compIdlot)
    {
        $this->compIdlot = $compIdlot;
    }

    /**
     * @return Produit
     */
    public function getCompIdproduit(): Produit
    {
        return $this->compIdproduit;
    }

    /**
     * @param Produit $compIdproduit
     */
    public function setCompIdproduit(Produit $compIdproduit): void
    {
        $this->compIdproduit = $compIdproduit;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="comp_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="composition_comp_id_seq", allocationSize=1, initialValue=1)
     */
    private $compId;

    /**
     * @var int
     *
     * @ORM\Column(name="comp_quantite", type="integer", nullable=false)
     */
    private $compQuantite;

    /**
     * @var Lot
     *
     * @ORM\ManyToOne(targetEntity="Lot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="comp_idlot", referencedColumnName="lt_idlot")
     * })
     */
    private $compIdlot;

    /**
     * @var Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="comp_idproduit", referencedColumnName="prot_id")
     * })
     */
    private $compIdproduit;


}
