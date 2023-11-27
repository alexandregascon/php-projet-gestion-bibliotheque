<?php

require_once "vendor/autoload.php";
require "bootstrap.php";

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validation;

// Définir les commandes

$app = new \Silly\Application();

$app->command("creerMagazine",function(SymfonyStyle $io) use ($entityManager) {

    $io->title("Créer un magazine : ");
    $titre = $io->ask("Saisir le titre : ");
    $num = $io->ask("Saisir le numéro : ");
    $datePublication = $io->ask("Saisir la date de publication : ");
    $datePublication = strtotime($datePublication);

    // Création du valdateur
    $validateur = Validation::createValidatorBuilder()
        ->enableAnnotationMapping()
        ->addDefaultDoctrineAnnotationReader()
        ->getValidator();

    try {
        $requete = new \App\UserStories\CreerMagazine\CreerMagazineRequete($num,$titre,new DateTime(),$datePublication->format("Y-m-d"));
        $creerMagazine = new \App\UserStories\CreerMagazine\CreerMagasine($entityManager, $validateur);
        $creerMagazine->execute($requete);
        $io->success("Création dans la base de données effectuée");
    }catch (Exception $e){
        $io->error($e->getMessage());
    }
});

$app->run();