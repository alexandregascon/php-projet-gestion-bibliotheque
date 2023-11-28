<?php

namespace App;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class BluRay extends Media{
    #[Column(type: Types::STRING,length: 80)]
    private string $realisateur;
    #[Column(type: Types::STRING,length: 80)]
    private string $duree;
    #[Column(type: Types::STRING,length: 4)]
    private string $anneeSortie;

    public function __construct()
    {
        parent::__construct();
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

    public function getType(): string
    {
        return strtolower(__CLASS__);
    }

}