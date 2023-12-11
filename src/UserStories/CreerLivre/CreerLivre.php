<?php

namespace App\UserStories\CreerLivre;

use App\Livre;
use App\Services\IsbnExistant;
use App\StatutMedia;
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
        $erreurs = $this->validateur->validate($requete);
        if (count($erreurs) > 0) {
            foreach ($erreurs as $erreur) {
                $resultat[] = $erreur->getMessage();
            }
            throw new \Exception(implode("SE", $resultat));
        }

        // Vérifier que l'isbn n'existe pas déjà
//        $livre = $this->entityManager->getRepository(Livre::class)->findOneBy(["isbn"=>$requete->isbn]);
//        if ($livre != null) {
//            throw .....
//        }
//        return $this->creationLivre(...);
//

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
        $livre->setStatut(StatutMedia::STATUT_NOUVEAU);
        $livre->setDureeEmprunt(21);
        // Enregistrer le livre en base de données
        $this->entityManager->persist($livre);
        $this->entityManager->flush();

        return true;
    }
}