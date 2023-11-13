<?php

namespace App\UserStories\CreerAdherent;

include_once "src/Services/EmailExistant.php";

use App\Adherent;
use App\Services\EmailExistant;
use App\Services\GenerateurNumeroAdherent;
use App\Services\NumeroExistant;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Logging\Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function PHPUnit\Framework\throwException;

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


    /**
     * @throws \Exception
     */
    public function execute(CreerAdherentRequete $requete)
    {

        // Valider les données en entrées (de la requête)
        if (count($this->validateur->validate($requete)) > 0) {
            throw new Exception("Une ou plusieures informations invalide(s)");
        }

        // Vérifier que l'email n'existe pas déjà
        $emailExistant = new EmailExistant();
        $verifMail = $emailExistant->verifier($requete, $this->entityManager);
        if ($verifMail == true) {

            // Générer un numéro d'adhérent au format AD-999999
            $numeroAdherent = $this->generateurNumeroAdherent->generer();
            // Vérifier que le numéro n'existe pas déjà
            $numExistant = new NumeroExistant();
            $verifNum = $numExistant->verifier($numeroAdherent,$this->entityManager);
            if($verifNum == false){
                while($verifNum == false){
                    // Générer un numéro d'adhérent au format AD-999999
                    $numeroAdherent = $this->generateurNumeroAdherent->generer();
                    // Vérifier que le numéro n'existe pas déjà
                    $numExistant = new NumeroExistant();
                    $verifNum = $numExistant->verifier($numeroAdherent,$this->entityManager);
                }
                // Créer l'adhérent
                return $this->creationAdherent($numeroAdherent, $requete);
            }else{
                // Créer l'adhérent
                return $this->creationAdherent($numeroAdherent, $requete);
            }
        }
    }

    /**
     * @param string $numeroAdherent
     * @param CreerAdherentRequete $requete
     * @return true
     */
    public function creationAdherent(string $numeroAdherent, CreerAdherentRequete $requete): bool
    {
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
    }
}