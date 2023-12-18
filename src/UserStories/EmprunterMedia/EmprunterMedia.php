<?php

namespace App\UserStories\EmprunterMedia;

use App\Adherent;
use App\Emprunt;
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
            if($media->getStatut() == StatutMedia::STATUT_DISPONIBLE and "Vérifier validité adhesion de l'adherent"){
                $emprunt = new Emprunt($media,$adherent);
                $media->setStatut(StatutMedia::STATUT_EMPRUNTE);
                $this->entityManager->persist($emprunt);
                $this->entityManager->flush();
            }else{
                throw new Exception("Le statut de ce média n'est pas à Disponible");
            }
        }else{
            throw new Exception("Ce média n'existe pas");
        }
    }
}