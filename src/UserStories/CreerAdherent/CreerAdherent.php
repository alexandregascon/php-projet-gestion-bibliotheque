<?php

namespace App\UserStories\CreerAdherent;

include_once "src/Services/EmailExistant.php";

use App\Adherent;
use App\Services\EmailExistant;
use App\Services\GenerateurNumeroAdherent;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreerAdherent
{
    private EntityManagerInterface $entityManager;
    private GenerateurNumeroAdherent $generateurNumeroAdherent;
    private ValidatorInterface $validateur;

    /**
     * @param EntityManagerInterface $entityManager
     * @param GenerateurNumeroAdherent $generateurNumeroAdherent
     * @param ValidatorInterface $validateur
     */
    public function __construct(EntityManagerInterface $entityManager, GenerateurNumeroAdherent $generateurNumeroAdherent, ValidatorInterface $validateur)
    {
        $this->entityManager = $entityManager;
        $this->generateurNumeroAdherent = $generateurNumeroAdherent;
        $this->validateur = $validateur;
    }


    public function execute(CreerAdherentRequete $requete): bool
    {

        // Valider les données en entrées (de la requête)
        if (count($this->validateur->validate($requete)) == 0) {

            // Vérifier que l'email n'existe pas déjà
            $emailVerif = new EmailExistant();
            try {
                $emailVerif->verifier($requete,$this->entityManager);
            }catch(\Exception $e) {
                echo $e->getMessage();
            }
            // Générer un numéro d'adhérent au format AD-999999
            $numeroAdherent = $this->generateurNumeroAdherent->generer();
            // Vérifier que le numéro n'existe pas déjà

            // Créer l'adhérent
            $adherent = new Adherent();
            $adherent->setNumAdherent($numeroAdherent);
            $adherent->setPrenom($requete->prenom);
            $adherent->setNom($requete->nom);
            $adherent->setMail($requete->mail);
            $adherent->setDateAdhesion(new \DateTime());
            // Enregistrer l'adhérent en base de données
            $this->entityManager->persist($adherent);
            $this->entityManager->flush();

            return true;
            }else{
                return false;
            }
        }
    }