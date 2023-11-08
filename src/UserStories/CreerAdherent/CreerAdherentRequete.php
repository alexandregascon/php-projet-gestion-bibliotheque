<?php

namespace App\UserStories\CreerAdherent;

use http\Message;
use Symfony\Component\Validator\Constraints as Assert;

class CreerAdherentRequete
{

    #[Assert\NotBlank (
        message : "Le prénom est obligatoire"
    )]
    public string $prenom;

    #[Assert\NotBlank (
        message : "Le nom est obligatoire"
    )]
    public string $nom;

    #[Assert\NotBlank (
        message : "L'email est obligatoire"
    )]
    #[Assert\Email(
        message : "L'email est incorrecte"
    )]
    public string $mail;

    /**
     * @param string $prenom
     * @param string $nom
     * @param string $mail
     */
    public function __construct(string $prenom, string $nom, string $mail)
    {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->mail = $mail;
    }


}