<?php

namespace App\Services;

use App\UserStories\CreerAdherent\CreerAdherent;
use App\UserStories\CreerAdherent\CreerAdherentRequete;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Logging\Exception;

class NumeroExistant
{
    public function verifier(string $numeroAdherent, EntityManagerInterface $entityManager) : bool{
        $repository =  $entityManager->getRepository(\App\Adherent::class);
        $findNum = $repository->findOneBy(["numAdherent" => $numeroAdherent]);
        if ($findNum !== null) {
            return false;
        }else{
            return true;
        }
    }
}
