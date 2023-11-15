<?php

namespace App;

class BluRay extends \App\Medias{
    private string $realisateur;
    private string $duree;
    private string $anneeSortie;

    public function __construct(string $titre,string $statut,\DateTime $dateCreation,int $dureeEmprunt)
    {
        parent::__construct($titre,$statut,$dateCreation,$dureeEmprunt);
    }

    /**
     * @return string
     */
    public function getRealisateur(): string
    {
        return $this->realisateur;
    }

    /**
     * @param string $realisateur
     */
    public function setRealisateur(string $realisateur): void
    {
        $this->realisateur = $realisateur;
    }

    /**
     * @return string
     */
    public function getDuree(): string
    {
        return $this->duree;
    }

    /**
     * @param string $duree
     */
    public function setDuree(string $duree): void
    {
        $this->duree = $duree;
    }

    /**
     * @return string
     */
    public function getAnneeSortie(): string
    {
        return $this->anneeSortie;
    }

    /**
     * @param string $anneeSortie
     */
    public function setAnneeSortie(string $anneeSortie): void
    {
        $this->anneeSortie = $anneeSortie;
    }

    /**
     * @return int
     */
    public function getDureeEmprunt(): int
    {
        return $this->dureeEmprunt;
    }

    /**
     * @param int $dureeEmprunt
     */
    public function setDureeEmprunt(int $dureeEmprunt): void
    {
        $this->dureeEmprunt = $dureeEmprunt;
    }



}