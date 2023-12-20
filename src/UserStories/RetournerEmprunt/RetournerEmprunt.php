<?php

namespace App\UserStories\RetournerEmprunt;

use App\Emprunt;
use App\StatutMedia;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Logging\Exception;

class RetournerEmprunt
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
    public function execute(string $numEmprunt){
        $emprunt = $this->entityManager->getRepository(Emprunt::class)->findOneBy(["numEmprunt"=>$numEmprunt]);
        $erreurs = [];
        if(!$emprunt){
            $erreurs[] = "Cet emprunt n'existe pas";
        }else{
            if($emprunt->getDateRetour() !== null){
                $erreurs[] = "Cet emprunt a déjà été rendu";
            }
        }
        if (count($erreurs) > 0) {
            throw new \Exception(implode("SE", $erreurs));
        }else{
            $dateRetour = new \DateTime();
            $emprunt->setDateRetour($dateRetour->format("d/m/Y"));
            $idMedia = $emprunt->getMedia()->getId();
            $media = $this->entityManager->getRepository(\App\Media::class)->findOneBy(["id"=>$idMedia]);
            $media->setStatut(StatutMedia::STATUT_DISPONIBLE);
            $this->entityManager->persist($emprunt);
            $this->entityManager->persist($media);
            $this->entityManager->flush();
            return true;
        }
    }
}