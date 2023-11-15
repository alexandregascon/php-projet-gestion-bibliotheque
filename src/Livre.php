<?php

namespace App;

use App\Medias;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Livre extends Medias{
    #[ORM\Column(type: "string")]
    private string $isbn;
    #[ORM\Column(type: "string")]
    private string $auteur;
    #[ORM\Column(type: "integer")]
    private int $nbPages;

    public function __construct(string $titre,string $statut,\DateTime $dateCreation,int $dureeEmprunt)
    {
        parent::__construct($titre,$statut,$dateCreation,$dureeEmprunt);
    }

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     */
    public function setIsbn(string $isbn): void
    {
        $this->isbn = $isbn;
    }

    /**
     * @return string
     */
    public function getAuteur(): string
    {
        return $this->auteur;
    }

    /**
     * @param string $auteur
     */
    public function setAuteur(string $auteur): void
    {
        $this->auteur = $auteur;
    }

    /**
     * @return int
     */
    public function getNbPages(): int
    {
        return $this->nbPages;
    }

    /**
     * @param int $nbPages
     */
    public function setNbPages(int $nbPages): void
    {
        $this->nbPages = $nbPages;
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