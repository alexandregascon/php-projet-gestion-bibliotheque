<?php

namespace App\UserStories\EmprunterMedia;

use App\Adherent;
use App\Emprunt;
use App\Media;
use App\StatutMedia;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Logging\Exception;

class EmprunterMedia
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Exception
     */
    public function execute(int $idMedia, string $numAdherent){
        $media = $this->entityManager->getRepository(\App\Media::class)->findOneBy(["id"=>$idMedia]);
        $adherent = $this->entityManager->getRepository(Adherent::class)->findOneBy(["numAdherent"=>$numAdherent]);
        $erreurs = [];
        if(!$media){
            $erreurs[] = "Ce média n'existe pas";
        }else{
            if($media->getStatut() !== StatutMedia::STATUT_DISPONIBLE){
                $erreurs[] = "Le statut de ce média n'est pas à Disponible";
            }
        }

        if(!$adherent){
            $erreurs[] = "Cet adherent n'existe pas";
        }else{
            $interval = date_diff($adherent->getDateAdhesion(),new \DateTime());
            $interval = $interval->format("%y");
            if($interval != 0){
                $erreurs[] = "L'adhésion de l'adherent n'est plus valide";
            }
        }

        if (count($erreurs) > 0) {
            throw new \Exception(implode("SE", $erreurs));
        }else{
            $emprunt = new Emprunt();
            $emprunt->setMedia($media);
            $emprunt->setAdherent($adherent);
            $numEmprunt = "EM-".random_int(1,9).random_int(1,9).random_int(1,9).random_int(1,9).random_int(1,9).random_int(1,9).random_int(1,9).random_int(1,9).random_int(1,9);
            $emprunt->setNumEmprunt($numEmprunt);
            $date = new \DateTime();
            $date = $date->format("d/m/Y");
            $emprunt->setDateEmprunt($date);
            $dateRetourEstimee = \DateTime::createFromFormat("d/m/Y",$date);
            $dureeEmprunt = $media->getDureeEmprunt();
            $dateRetourEstimee = $dateRetourEstimee->modify("+ $dureeEmprunt days");
            $emprunt->setDateRetourEstimee($dateRetourEstimee->format("d/m/Y"));
            $media->setStatut(StatutMedia::STATUT_EMPRUNTE);
            $this->entityManager->persist($emprunt);
            $this->entityManager->persist($media);
            $this->entityManager->flush();
            return true;
        }
    }
}