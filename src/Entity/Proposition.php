<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proposition
 *
 * @ORM\Table(name="proposition", indexes={@ORM\Index(name="IDX_C7CDC353EB8855F7", columns={"prop_client"})})
 * @ORM\Entity(repositoryClass="App\Repository\PropositionRepository")
 */
class Proposition
{
    /**
     * @return int
     */
    public function getPropId(): int
    {
        return $this->propId;
    }

    /**
     * @param int $propId
     */
    public function setPropId(int $propId): void
    {
        $this->propId = $propId;
    }

    /**
     * @return float
     */
    public function getPropPrix(): float
    {
        return $this->propPrix;
    }

    /**
     * @param float $propPrix
     */
    public function setPropPrix(float $propPrix): void
    {
        $this->propPrix = $propPrix;
    }

    /**
     * @return int|null
     */
    public function getPropNombre(): ?int
    {
        return $this->propNombre;
    }

    /**
     * @param int|null $propNombre
     */
    public function setPropNombre(?int $propNombre): void
    {
        $this->propNombre = $propNombre;
    }

    /**
     * @return \DateTime|null
     */
    public function getPropDate()
    {
        return $this->propDate;
    }

    /**
     * @param \DateTime|null $propDate
     */
    public function setPropDate($propDate): void
    {
        $this->propDate = $propDate;
    }

    /**
     * @return bool|null
     */
    public function getPropAccept(): ?bool
    {
        return $this->propAccept;
    }

    /**
     * @param bool|null $propAccept
     */
    public function setPropAccept(?bool $propAccept): void
    {
        $this->propAccept = $propAccept;
    }

    /**
     * @return \Client
     */
    public function getPropClient(): \Client
    {
        return $this->propClient;
    }

    /**
     * @param Client $propClient
     */
    public function setPropClient(Client $propClient): void
    {
        $this->propClient = $propClient;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="prop_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="proposition_prop_id_seq", allocationSize=1, initialValue=1)
     */
    private $propId;

    /**
     * @var float
     *
     * @ORM\Column(name="prop_prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $propPrix;

    /**
     * @var int|null
     *
     * @ORM\Column(name="prop_nombre", type="integer", nullable=true, options={"default"="1"})
     */
    private $propNombre = 1;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="prop_date", type="datetime", nullable=true, options={"default"="CURRENT_DATE"})
     */
    private $propDate = 'CURRENT_DATE';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="prop_accept", type="boolean", nullable=true)
     */
    private $propAccept = false;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prop_client", referencedColumnName="cl_id")
     * })
     */
    private $propClient;

    /**
     * @var Lot
     *
     * @ORM\ManyToOne(targetEntity="Lot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prop_lot", referencedColumnName="lt_idlot")
     * })
     */
    private $propLot;

    /**
     * @return Lot
     */
    public function getPropLot(): Lot
    {
        return $this->propLot;
    }

    /**
     * @param Lot $propLot
     */
    public function setPropLot(Lot $propLot): void
    {
        $this->propLot = $propLot;
    }




}
