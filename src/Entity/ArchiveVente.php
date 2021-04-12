<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArchiveVente
 *
 * @ORM\Table(name="archive_vente", indexes={@ORM\Index(name="IDX_EF674556D33FA1E6", columns={"lt_idlot"}), @ORM\Index(name="IDX_EF6745566ABAF5FC", columns={"av_idclient"})})
 * @ORM\Entity(repositoryClass="App\Repository\ArchiveVenteRepository")
 */
class ArchiveVente
{
    /**
     * @return int
     */
    public function getAvIdarchive(): int
    {
        return $this->avIdarchive;
    }

    /**
     * @param int $avIdarchive
     */
    public function setAvIdarchive(int $avIdarchive): void
    {
        $this->avIdarchive = $avIdarchive;
    }

    /**
     * @return float
     */
    public function getAvPrix(): float
    {
        return $this->avPrix;
    }

    /**
     * @param float $avPrix
     */
    public function setAvPrix(float $avPrix): void
    {
        $this->avPrix = $avPrix;
    }

    /**
     * @return \Lot
     */
    public function getLtIdlot(): \Lot
    {
        return $this->ltIdlot;
    }

    /**
     * @param \Lot $ltIdlot
     */
    public function setLtIdlot(\Lot $ltIdlot): void
    {
        $this->ltIdlot = $ltIdlot;
    }

    /**
     * @return \Client
     */
    public function getAvIdclient(): \Client
    {
        return $this->avIdclient;
    }

    /**
     * @param \Client $avIdclient
     */
    public function setAvIdclient(\Client $avIdclient): void
    {
        $this->avIdclient = $avIdclient;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="av_idarchive", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="archive_vente_av_idarchive_seq", allocationSize=1, initialValue=1)
     */
    private $avIdarchive;

    /**
     * @var float
     *
     * @ORM\Column(name="av_prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $avPrix;

    /**
     * @var \Lot
     *
     * @ORM\ManyToOne(targetEntity="Lot")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lt_idlot", referencedColumnName="lt_idlot")
     * })
     */
    private $ltIdlot;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="av_idclient", referencedColumnName="cl_id")
     * })
     */
    private $avIdclient;


}
