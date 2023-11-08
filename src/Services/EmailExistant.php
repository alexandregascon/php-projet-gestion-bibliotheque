<?php

namespace App\Services;

use App\UserStories\CreerAdherent\CreerAdherent;
use App\UserStories\CreerAdherent\CreerAdherentRequete;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Logging\Exception;

class EmailExistant
{
     public function verifier(CreerAdherentRequete $requete, EntityManagerInterface $entityManager) : bool{
         $repository =  $entityManager->getRepository(\App\Adherent::class);
         $findMail = $repository->findOneBy(["mail" => $requete->mail]);
         if ($findMail == null) {
            throw new \Exception("Cet email est déjà utilisé");
         }else{
             return true;
         }
     }
}