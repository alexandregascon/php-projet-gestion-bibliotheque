<?php

namespace App;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Magazine extends \App\Medias{
    #[ORM\Column(type: "string")]
    private string $num;
    #[ORM\Column(type: "datetime")]
    private \DateTime $datePublication;

    public function __construct(string $titre,string $statut,\DateTime $dateCreation,int $dureeEmprunt)
    {
        parent::__construct($titre,$statut,$dateCreation,$dureeEmprunt);
    }

    /**
     * @return string
     */
    public function getNum(): string
    {
        return $this->num;
    }

    /**
     * @param string $num
     */
    public function setNum(string $num): void
    {
        $this->num = $num;
    }

    /**
     * @return \DateTime
     */
    public function getDatePublication(): \DateTime
    {
        return $this->datePublication;
    }

    /**
     * @param \DateTime $datePublication
     */
    public function setDatePublication(\DateTime $datePublication): void
    {
        $this->datePublication = $datePublication;
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