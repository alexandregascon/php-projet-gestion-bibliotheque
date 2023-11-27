<?php

namespace App\UserStories\CreerMagazine;

use http\Message;
use Symfony\Component\Validator\Constraints as Assert;

class CreerMagazineRequete
{
    #[Assert\NotBlank (
        message : "Le numéro est obligatoire"
    )]
    public string $num;

    #[Assert\NotBlank (
        message : "Le titre est obligatoire"
    )]
    public string $titre;

    #[Assert\NotBlank (
        message : "La date de création est obligatoire"
    )]
    public \DateTime $dateCreation;

    #[Assert\NotBlank (
        message : "La date de publication est obligatoire"
    )]
    public \DateTime $datePublication;

    /**
     * @param string $num
     * @param string $titre
     * @param \DateTime $dateCreation
     * @param \DateTime $datePublication
     */
    public function __construct(string $num,string $titre, \DateTime $dateCreation, \DateTime $datePublication)
    {
        $this->num=$num;
        $this->titre=$titre;
        $this->dateCreation=$dateCreation;
        $this->datePublication=$datePublication;
    }
}