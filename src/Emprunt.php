<?php

namespace App;

class Emprunt{
    private int $idEmprunt;
    private \DateTime $dateEmprunt;
    private \DateTime $dateRetourEstimee;
    private ?\DateTime $dateRetour;
    private Adherent $adherent;
    private \App\Medias $media;

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
            return false;
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
     * @return \App\Medias
     */
    public function getMedia(): \App\Medias
    {
        return $this->media;
    }

    /**
     * @param \App\Medias $media
     */
    public function setMedia(\App\Medias $media): void
    {
        $this->media = $media;
    }



}