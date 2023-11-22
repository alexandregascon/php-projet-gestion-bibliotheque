<?php

namespace App\UserStories\CreerLivre;

use http\Message;
use Symfony\Component\Validator\Constraints as Assert;

class CreerLivreRequete
{
    #[Assert\NotBlank (
        message : "L'isbn est obligatoire"
    )]
    public string $isbn;
    #[Assert\NotBlank (
        message : "L'auteur est obligatoire"
    )]
    public string $auteur;

    #[Assert\NotBlank (
        message : "Le nombre de pages est obligatoire"
    )]
    public int $nbPages;

    #[Assert\NotBlank (
        message : "Le titre est obligatoire"
    )]
    public string $titre;

    #[Assert\NotBlank (
        message : "La date de création est obligatoire"
    )]
    public \DateTime $dateCreation;

    /**
     * @param string $auteur
     * @param int $nbPages
     */
    public function __construct(string $isbn,string $auteur,int $nbPages, string $titre, \DateTime $dateCreation)
    {
        $this->isbn=$isbn;
        $this->auteur=$auteur;
        $this->nbPages=$nbPages;
        $this->titre=$titre;
        $this->dateCreation=$dateCreation;
    }
}