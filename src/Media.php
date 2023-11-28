<?php

namespace App;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[ORM\Entity]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type",type: "string")]
#[ORM\DiscriminatorMap(["magazine" => "Magazine", "livre" => "Livre", "bluray" => "BluRay"])]
abstract class Media{

    #[Id]
    #[GeneratedValue]
    #[Column(type: Types::INTEGER)]
    protected int $id;
    #[Column(type: Types::STRING,length: 80)]
    protected string $titre;
    #[Column(type: Types::STRING,length: 80)]
    protected string $statut;
    #[Column(type: "date")]
    protected \DateTime $dateCreation;
    #[Column(type: Types::INTEGER)]
    protected int $dureeEmprunt;

    public function __construct()
    {
    }

    abstract function getType():string;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return int
     */
    public function getStatut(): int
    {
        return $this->statut;
    }

    /**
     * @param string $statut
     */
    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation(\DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
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