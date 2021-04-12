<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @return int
     */
    public function getProtId(): int
    {
        return $this->protId;
    }

    /**
     * @param int $protId
     */
    public function setProtId(int $protId): void
    {
        $this->protId = $protId;
    }

    /**
     * @return string
     */
    public function getProtNom(): string
    {
        return $this->protNom;
    }

    /**
     * @param string $protNom
     */
    public function setProtNom(string $protNom): void
    {
        $this->protNom = $protNom;
    }

    /**
     * @return string
     */
    public function getProtType(): string
    {
        return $this->protType;
    }

    /**
     * @param string $protType
     */
    public function setProtType(string $protType): void
    {
        $this->protType = $protType;
    }

    /**
     * @return string
     */
    public function getProtDescription(): string
    {
        return $this->protDescription;
    }

    /**
     * @param string $protDescription
     */
    public function setProtDescription(string $protDescription): void
    {
        $this->protDescription = $protDescription;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="prot_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="produit_prot_id_seq", allocationSize=1, initialValue=1)
     */
    private $protId;

    /**
     * @var string
     *
     * @ORM\Column(name="prot_nom", type="string", length=100, nullable=false)
     */
    private $protNom;

    /**
     * @var string
     *
     * @ORM\Column(name="prot_type", type="string", nullable=false)
     */
    private $protType;

    /**
     * @var string
     *
     * @ORM\Column(name="prot_description", type="string", length=255, nullable=false)
     */
    private $protDescription;


}
