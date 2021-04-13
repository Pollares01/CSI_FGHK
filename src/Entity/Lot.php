<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lot
 *
 * @ORM\Table(name="lot")
 * @ORM\Entity(repositoryClass="App\Repository\LotRepository")
 */
class Lot
{
    /**
     * @return int
     */
    public function getLtIdlot(): int
    {
        return $this->ltIdlot;
    }

    /**
     * @param int $ltIdlot
     */
    public function setLtIdlot(int $ltIdlot): void
    {
        $this->ltIdlot = $ltIdlot;
    }

    /**
     * @return float
     */
    public function getLtPrixMinimum(): float
    {
        return $this->ltPrixMinimum;
    }

    /**
     * @param float $ltPrixMinimum
     */
    public function setLtPrixMinimum(float $ltPrixMinimum): void
    {
        $this->ltPrixMinimum = $ltPrixMinimum;
    }

    /**
     * @return float
     */
    public function getLtPrixEstime(): float
    {
        return $this->ltPrixEstime;
    }

    /**
     * @param float $ltPrixEstime
     */
    public function setLtPrixEstime(float $ltPrixEstime): void
    {
        $this->ltPrixEstime = $ltPrixEstime;
    }


    public function getLtDateDebut()
    {
        return $this->ltDateDebut;
    }

    /**
     * @param DateTime $ltDateDebut
     */
    public function setLtDateDebut(DateTime $ltDateDebut): void
    {
        $this->ltDateDebut = $ltDateDebut;
    }

    /**
     * @return DateTime|null
     */
    public function getLtDateFin()
    {
        return $this->ltDateFin;
    }

    /**
     * @param DateTime $ltDateFin
     */
    public function setLtDateFin(DateTime $ltDateFin): void
    {
        $this->ltDateFin = $ltDateFin;
    }

    /**
     * @return string
     */
    public function getLtStatut(): string
    {
        return $this->ltStatut;
    }

    /**
     * @param string $ltStatut
     */
    public function setLtStatut(string $ltStatut): void
    {
        $this->ltStatut = $ltStatut;
    }

    /**
     * @return DateTime|null
     */
    public function getLtDateVente(): ?DateTime
    {
        return $this->ltDateVente;
    }

    /**
     * @param DateTime|null $ltDateVente
     */
    public function setLtDateVente(?DateTime $ltDateVente): void
    {
        $this->ltDateVente = $ltDateVente;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="lt_idlot", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="lot_lt_idlot_seq", allocationSize=1, initialValue=1)
     */
    private $ltIdlot;

    /**
     * @var float
     *
     * @ORM\Column(name="lt_prix_minimum", type="float", precision=10, scale=0, nullable=false)
     */
    private $ltPrixMinimum;

    /**
     * @var float
     *
     * @ORM\Column(name="lt_prix_estime", type="float", precision=10, scale=0, nullable=false)
     */
    private $ltPrixEstime;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="lt_date_debut", type="date", nullable=false)
     */
    private $ltDateDebut;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="lt_date_fin", type="date", nullable=false)
     */
    private $ltDateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="lt_statut", type="string", nullable=false)
     */
    private $ltStatut;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="lt_date_vente", type="date", nullable=true)
     */
    private $ltDateVente;

    private $nbTypeArt;

    /**
     * @return mixed
     */
    public function getNbTypeArt()
    {
        return $this->nbTypeArt;
    }

    /**
     * @param mixed $nbTypeArt
     */
    public function setNbTypeArt($nbTypeArt): void
    {
        $this->nbTypeArt = $nbTypeArt;
    }


    /**
     * @ORM\OneToMany(targetEntity=Composition::class, mappedBy="compIdlot")
     */
    private $composition;

    /**
     * @return mixed
     */
    public function getComposition()
    {
        return $this->composition;
    }

    /**
     * @param mixed $composition
     */
    public function setComposition($composition): void
    {
        $this->composition = $composition;
    }




}
