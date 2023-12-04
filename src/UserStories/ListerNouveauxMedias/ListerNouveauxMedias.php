<?php

namespace App\UserStories\ListerNouveauxMedias;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ListerNouveauxMedias
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(){
        $medias = $this->entityManager->getRepository(\App\Media::class)->findBy(["statut"=>"Nouveau"],["dateCreation"=>"DESC"]);
        $resultat = [];
        foreach ($medias as $media){
            $resultat[] = ["id"=>$media->getId(),"titre"=>$media->getTitre(),"statut"=>$media->getStatut(),"dateCreation"=>$media->getDateCreation(),"type"=>$media->getType()];
        }
        return $resultat;
    }

}