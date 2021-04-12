<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @return int
     */
    public function getClId(): int
    {
        return $this->clId;
    }

    /**
     * @param int $clId
     */
    public function setClId(int $clId): void
    {
        $this->clId = $clId;
    }

    /**
     * @return string
     */
    public function getClMotDePasse(): string
    {
        return $this->clMotDePasse;
    }

    /**
     * @param string $clMotDePasse
     */
    public function setClMotDePasse(string $clMotDePasse): void
    {
        $this->clMotDePasse = $clMotDePasse;
    }

    /**
     * @return string
     */
    public function getClEmail(): string
    {
        return $this->clEmail;
    }

    /**
     * @param string $clEmail
     */
    public function setClEmail(string $clEmail): void
    {
        $this->clEmail = $clEmail;
    }

    /**
     * @return string
     */
    public function getClNom(): string
    {
        return $this->clNom;
    }

    /**
     * @param string $clNom
     */
    public function setClNom(string $clNom): void
    {
        $this->clNom = $clNom;
    }

    /**
     * @return string
     */
    public function getClPrenom(): string
    {
        return $this->clPrenom;
    }

    /**
     * @param string $clPrenom
     */
    public function setClPrenom(string $clPrenom): void
    {
        $this->clPrenom = $clPrenom;
    }

    /**
     * @return \DateTime|null
     */
    public function getClDateDeNaiss(): ?\DateTime
    {
        return $this->clDateDeNaiss;
    }

    /**
     * @param \DateTime|null $clDateDeNaiss
     */
    public function setClDateDeNaiss(?\DateTime $clDateDeNaiss): void
    {
        $this->clDateDeNaiss = $clDateDeNaiss;
    }

    /**
     * @return \DateTime|null
     */
    public function getClDateInscription()
    {
        return $this->clDateInscription;
    }

    /**
     * @param \DateTime|null $clDateInscription
     */
    public function setClDateInscription($clDateInscription): void
    {
        $this->clDateInscription = $clDateInscription;
    }

    /**
     * @return string
     */
    public function getClAdresse(): string
    {
        return $this->clAdresse;
    }

    /**
     * @param string $clAdresse
     */
    public function setClAdresse(string $clAdresse): void
    {
        $this->clAdresse = $clAdresse;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="cl_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="client_cl_id_seq", allocationSize=1, initialValue=1)
     */
    private $clId;

    /**
     * @var string
     *
     * @ORM\Column(name="cl_mot_de_passe", type="string", length=255, nullable=false)
     */
    private $clMotDePasse;

    /**
     * @var string
     *
     * @ORM\Column(name="cl_email", type="string", length=50, nullable=false)
     */
    private $clEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="cl_nom", type="string", length=20, nullable=false)
     */
    private $clNom;

    /**
     * @var string
     *
     * @ORM\Column(name="cl_prenom", type="string", length=20, nullable=false)
     */
    private $clPrenom;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="cl_date_de_naiss", type="date", nullable=true)
     */
    private $clDateDeNaiss;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="cl_date_inscription", type="date", nullable=true, options={"default"="CURRENT_DATE"})
     */
    private $clDateInscription = 'CURRENT_DATE';

    /**
     * @var string
     *
     * @ORM\Column(name="cl_adresse", type="string", length=50, nullable=false)
     */
    private $clAdresse;


}
