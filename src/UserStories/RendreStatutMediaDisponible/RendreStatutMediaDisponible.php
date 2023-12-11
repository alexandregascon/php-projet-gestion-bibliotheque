<?php

namespace App\UserStories\RendreStatutMediaDisponible;

use App\StatutMedia;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Logging\Exception;

class RendreStatutMediaDisponible
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(int $id){
        $media = $this->entityManager->getRepository(\App\Media::class)->findOneBy(["id"=>$id]);
        if($media){
            if($media->getStatut() == StatutMedia::STATUT_NOUVEAU){
                $media->setStatut(StatutMedia::STATUT_DISPONIBLE);
                $this->entityManager->flush();
            }else{
                throw new Exception("Le statut de ce média n'est pas à Nouveau");
            }
        }else{
            throw new Exception("Ce média n'existe pas");
        }
    }
}