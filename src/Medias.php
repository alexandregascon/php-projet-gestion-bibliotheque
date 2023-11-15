<?php

namespace App;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type",type: "string")]
#[ORM\DiscriminatorMap(["magazine" => "Magazine", "livre" => "Livre", "bluray" => "BluRay"])]
abstract class Medias{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected int $id;
    #[ORM\Column(type: "string")]
    protected string $titre;
    #[ORM\Column(type: "string")]
    protected string $statut;
    #[ORM\Column(type: "datetime")]
    protected \DateTime $dateCreation;
    #[ORM\Column(type: "integer")]
    protected int $dureeEmprunt;

    /**
     * @param string $titre
     * @param string $statut
     * @param \DateTime $dateCreation
     */
    public function __construct(string $titre, string $statut, \DateTime $dateCreation, int $dureeEmprunt)
    {
        $this->titre = $titre;
        $this->statut = $statut;
        $this->dateCreation = $dateCreation;
        $this->dureeEmprunt = $dureeEmprunt;
    }


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
     * @return string
     */
    public function getStatut(): string
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