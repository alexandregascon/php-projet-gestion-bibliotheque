<?php

namespace App\Services;

use App\UserStories\CreerLivre\CreerLivreRequete;
use App\UserStories\CreerMagazine\CreerMagazineRequete;
use Doctrine\ORM\EntityManagerInterface;

class NumMagazineExistant
{
    /**
     * @throws \Exception
     */
    public function verifier(CreerMagazineRequete $requete, EntityManagerInterface $entityManager): bool
    {
        $repository = $entityManager->getRepository(\App\Magazine::class);
        $findNum = $repository->findOneBy(["num" => $requete->num]);
        if ($findNum !== null) {
            throw new \Exception("Ce numéro est déjà utilisé");
        } else {
            return true;
        }
    }
}