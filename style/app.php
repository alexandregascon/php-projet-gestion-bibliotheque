<?php

require_once "vendor/autoload.php";
require "bootstrap.php";

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// Définir les commandes

$app = new \Silly\Application();

$app->command("showNewMedias",function(SymfonyStyle $io) use ($entityManager) {
    $io->title("Liste des nouveaux médias");
    $medias = $entityManager->getRepository(\App\Media::class)->findBy(["statut"=>"Nouveau"]);
    foreach ($medias as $media){
        $io->text($media->getTitre());
    }
});

$app->run();