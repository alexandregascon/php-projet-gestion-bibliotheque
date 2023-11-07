<?php

namespace App;

abstract class Medias{

    protected int $id;
    protected string $titre;
    protected string $statut;
    protected \DateTime $dateCreation;

    /**
     * @param string $titre
     * @param string $statut
     * @param \DateTime $dateCreation
     */
    public function __construct(string $titre, string $statut, \DateTime $dateCreation)
    {
        $this->titre = $titre;
        $this->statut = $statut;
        $this->dateCreation = $dateCreation;
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



}