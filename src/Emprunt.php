<?php

namespace App;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use PHPUnit\Logging\Exception;
use Symfony\Component\Validator\Constraints\IsNull;
use Symfony\Component\Validator\Constraints\NotNull;

#[Entity]
class Emprunt{
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue]
    private int $idEmprunt;
    #[Column(type: "string")]
    private string $numEmprunt;
    #[Column(type: "datetime")]
    private \DateTime $dateEmprunt;
    #[Column(type: "datetime")]
    private \DateTime $dateRetourEstimee;
    #[Column(type: "datetime",nullable: true)]
    private ?\DateTime $dateRetour = null;
    #[ManyToOne(targetEntity: Adherent::class)]
    private Adherent $adherent;
    #[ManyToOne(targetEntity: Media::class)]
    private \App\Media $media;

    public function __construct()
    {
    }

    public function empruntRendu() : bool{
        return isset($this->dateRetour);
    }

    public function empruntEnRetard() : bool{
        $date = new \DateTime();
        $date = $date->format("m/d/Y");
        if($this->empruntRendu() == false and strtotime($this->dateRetourEstimee->format("m/d/Y")) < strtotime($date)){
            return true;
        }else{
            throw new Exception("L'emprunt est en retard");
        }
    }

    /**
     * @return int
     */
    public function getIdEmprunt(): int
    {
        return $this->idEmprunt;
    }

    /**
     * @param int $idEmprunt
     */
    public function setIdEmprunt(int $idEmprunt): void
    {
        $this->idEmprunt = $idEmprunt;
    }

    /**
     * @return \DateTime
     */
    public function getDateEmprunt(): \DateTime
    {
        return $this->dateEmprunt;
    }

    /**
     * @param string $dateEmrpunt
     */
    public function setDateEmprunt(string $dateEmprunt): void
    {
        $this->dateEmprunt = \DateTime::createFromFormat("d/m/Y","$dateEmprunt");
    }

    /**
     * @return \DateTime
     */
    public function getDateRetourEstimee(): \DateTime
    {
        return $this->dateRetourEstimee;
    }

    /**
     * @param string $dateRetourEstimee
     */
    public function setDateRetourEstimee(string $dateRetourEstimee): void
    {
        $this->dateRetourEstimee = \DateTime::createFromFormat("d/m/Y","$dateRetourEstimee");
    }

    /**
     * @return ?\DateTime
     */
    public function getDateRetour(): ?\DateTime
    {
        return $this->dateRetour;
    }

    /**
     * @param string $dateRetour
     */
    public function setDateRetour(string $dateRetour): void
    {
        $this->dateRetour = \DateTime::createFromFormat("d/m/Y","$dateRetour");
    }

    /**
     * @return Adherent
     */
    public function getAdherent(): Adherent
    {
        return $this->adherent;
    }

    /**
     * @param Adherent $adherent
     */
    public function setAdherent(Adherent $adherent): void
    {
        $this->adherent = $adherent;
    }

    /**
     * @return \App\Media
     */
    public function getMedia(): \App\Media
    {
        return $this->media;
    }

    /**
     * @param \App\Media $media
     */
    public function setMedia(\App\Media $media): void
    {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getNumEmprunt(): string
    {
        return $this->numEmprunt;
    }

    /**
     * @param string $numEmprunt
     */
    public function setNumEmprunt(string $numEmprunt): void
    {
        $this->numEmprunt = $numEmprunt;
    }



}