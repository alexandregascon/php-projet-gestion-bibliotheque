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

    public function execute(int $idMedia, string $numAdherent){
        $media = $this->entityManager->getRepository(\App\Media::class)->findOneBy(["id"=>$idMedia]);
        $adherent = $this->entityManager->getRepository(Adherent::class)->findOneBy(["numAdherent"=>$numAdherent]);
        if($media and $adherent){
            $interval = date_diff($adherent->getDateAdhesion(),new \DateTime());
            $interval = $interval->format("%y");
            if($media->getStatut() == StatutMedia::STATUT_DISPONIBLE and $interval == 0){
                $emprunt = new Emprunt();
                $emprunt->setMedia($media);
                $emprunt->setAdherent($adherent);
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
            }else{
                throw new Exception("Le statut de ce média n'est pas à Disponible ou l'adhésion de l'adherent n'est plus valide");
            }
        }else{
            throw new Exception("Ce média ou cet Adherent n'existe pas");
        }
    }
}