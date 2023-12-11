<?php

namespace App\UserStories\CreerMagazine;

use App\Livre;
use App\Magazine;
use App\Services\IsbnExistant;
use App\Services\NumMagazineExistant;
use App\StatutMedia;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Logging\Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreerMagasine
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validateur;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validateur
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validateur)
    {
        $this->entityManager = $entityManager;
        $this->validateur = $validateur;
    }

    /**
     * @throws \Exception
     */
    public function execute(CreerMagazineRequete $requete)
    {

        // Valider les données en entrées (de la requête)
        $erreurs = $this->validateur->validate($requete);
        if (count($erreurs) > 0) {
            foreach ($erreurs as $erreur){
                $resultat = [$erreur->getMessage()];
            }
            throw new \Exception(implode("<br>",$resultat));
        }

        // Vérifier que le numéro n'existe pas déjà
        $numExistant = new NumMagazineExistant();
        $verifNum = $numExistant->verifier($requete, $this->entityManager);
        if ($verifNum == true) {
            return $this->creationMagazine($requete);
        }
    }

    /**
     * @param string $isbn
     * @param CreerMagazineRequete $requete
     * @return true
     */
    public function creationMagazine(CreerMagazineRequete $requete): bool
    {
        $magazine = new Magazine();
        $magazine->setNum($requete->num);
        $magazine->setTitre($requete->titre);
        $magazine->setDateCreation($requete->dateCreation);
        $magazine->setDatePublication($requete->datePublication);
        $magazine->setStatut(StatutMedia::STATUT_NOUVEAU);
        $magazine->setDureeEmprunt(10);
        // Enregistrer le livre en base de données
        $this->entityManager->persist($magazine);
        $this->entityManager->flush();

        return true;
    }
}