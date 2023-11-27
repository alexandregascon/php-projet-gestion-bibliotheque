<?php

namespace App\UserStories\CreerMagazine;

use App\Livre;
use App\Magazine;
use App\Services\IsbnExistant;
use App\Services\NumMagazineExistant;
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
        if (count($this->validateur->validate($requete)) > 0) {
            throw new Exception("Une ou plusieures informations invalide(s)");
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
        $magazine->setStatut("Nouveau");
        $magazine->setDureeEmprunt(10);
        // Enregistrer le livre en base de données
        $this->entityManager->persist($magazine);
        $this->entityManager->flush();

        return true;
    }
}