<?php

namespace App;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use PHPUnit\Logging\Exception;

#[Entity]
class Emprunt{
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue]
    private int $idEmprunt;
    #[Column(type: "datetime")]
    private \DateTime $dateEmprunt;
    #[Column(type: "datetime")]
    private \DateTime $dateRetourEstimee;
    #[Column(type: "datetime")]
    private ?\DateTime $dateRetour;
    private Adherent $adherent;
    private \App\Media $media;

    public function __construct(Media $media, Adherent $adherent)
    {
        $this->dateEmprunt = new \DateTime();
        $this->media = $media;
        $date = $this->dateEmprunt;
        $nbJoursEmprunt = $this->media->getDureeEmprunt();
        $this->dateRetourEstimee = $date->modify("+ $nbJoursEmprunt days");
        $this->adherent = $adherent;
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



}