<?php

namespace App\UserStories\CreerLivre;

use App\Livre;
use App\Services\IsbnExistant;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Logging\Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreerLivre
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
    public function execute(CreerLivreRequete $requete)
    {

        // Valider les données en entrées (de la requête)
        if (count($this->validateur->validate($requete)) > 0) {
            throw new Exception("Une ou plusieures informations invalide(s)");
        }

        // Vérifier que l'isbn n'existe pas déjà
        $isbnExistant = new IsbnExistant();
        $verifIsbn = $isbnExistant->verifier($requete, $this->entityManager);
        if ($verifIsbn == true) {
                return $this->creationLivre($requete);
            }
        }

    /**
     * @param string $isbn
     * @param CreerLivreRequete $requete
     * @return true
     */
    public function creationLivre(CreerLivreRequete $requete): bool
    {
        $livre = new Livre();
        $livre->setIsbn($requete->isbn);
        $livre->setTitre($requete->titre);
        $livre->setAuteur($requete->auteur);
        $livre->setDateCreation($requete->dateCreation);
        $livre->setNbPages($requete->nbPages);
        $livre->setStatut("Nouveau");
        $livre->setDureeEmprunt(21);
        // Enregistrer le livre en base de données
        $this->entityManager->persist($livre);
        $this->entityManager->flush();

        return true;
    }
}