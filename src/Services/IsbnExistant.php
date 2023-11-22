<?php

namespace App\Services;

use App\UserStories\CreerLivre\CreerLivreRequete;
use Doctrine\ORM\EntityManagerInterface;

class IsbnExistant
{
    /**
     * @throws \Exception
     */
    public function verifier(CreerLivreRequete $requete, EntityManagerInterface $entityManager): bool
    {
        $repository = $entityManager->getRepository(\App\Livre::class);
        $findIsbn = $repository->findOneBy(["isbn" => $requete->isbn]);
        if ($findIsbn !== null) {
            throw new \Exception("Cet isbn est déjà utilisé");
        } else {
            return true;
        }
    }
}