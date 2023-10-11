<?php

namespace App;

class Adherent{
    private int $idAdherent;
    private string $numAdherent;
    private string $prenom;
    private string $nom;
    private string $mail;
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