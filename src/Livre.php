<?php

namespace App;

use App\Media;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

#[ORM\Entity]
class Livre extends Media{
    #[Column(type: Types::STRING,length: 80)]
    private string $isbn;
    #[Column(type: Types::STRING,length: 80)]
    private string $auteur;
    #[Column(type: Types::INTEGER)]
    private int $nbPages;

    public function __construct()
    {
        parent::__construct();
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

    public function getType(): string
    {
        return strtolower(__CLASS__);
    }

}