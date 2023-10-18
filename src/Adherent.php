<?php

namespace App;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Adherent{
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue]
    private int $idAdherent;
    #[Column(type: Types::STRING, length: 9)]
    private string $numAdherent;
    #[Column(type: Types::STRING,length: 80)]
    private string $prenom;
    #[Column(type: Types::STRING,length: 80)]
    private string $nom;
    #[Column(type: Types::STRING,length: 80)]
    private string $mail;
    #[Column(type: Types::STRING,length: 4)]
    private string $dateAdhesion;

    public function __construct(){
    }

    /**
     * @return int
     */
    public function getIdAdherent(): int
    {
        return $this->idAdherent;
    }

    /**
     * @param int $idAdherent
     */
    public function setIdAdherent(int $idAdherent): void
    {
        $this->idAdherent = $idAdherent;
    }

    /**
     * @return string
     */
    public function getNumAdherent(): string
    {
        return $this->numAdherent;
    }

    /**
     * @param string $numAdherent
     */
    public function setNumAdherent(string $numAdherent): void
    {
        $this->numAdherent = $numAdherent;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getDateAdhesion(): string
    {
        return $this->dateAdhesion;
    }

    /**
     * @param string $dateAdhesion
     */
    public function setDateAdhesion(string $dateAdhesion): void
    {
        $this->dateAdhesion = $dateAdhesion;
    }



}