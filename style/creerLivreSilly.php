<?php

require_once "vendor/autoload.php";
require "bootstrap.php";

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validation;

// Définir les commandes

$app = new \Silly\Application();

$app->command("creerLivre",function(SymfonyStyle $io) use ($entityManager) {

    $io->title("Créer un livre : ");
    $titre = $io->ask("Saisir le titre : ");
    $isbn = $io->ask("Saisir l'isbn : ");
    $auteur = $io->ask("Saisir le nom de l'auteur : ");
    $nbPages = $io->ask("Saisir le nombre de pages : ");

    // Création du valdateur
    $validateur = Validation::createValidatorBuilder()
        ->enableAnnotationMapping()
        ->addDefaultDoctrineAnnotationReader()
        ->getValidator();

    try {
        $requete = new \App\UserStories\CreerLivre\CreerLivreRequete($isbn,$auteur,$nbPages,$titre,new DateTime());
        $creerLivre = new \App\UserStories\CreerLivre\CreerLivre($entityManager, $validateur);
        $creerLivre->execute($requete);
        $io->success("Création dans la base de données effectuée");
    }catch (Exception $e){
        $io->error($e->getMessage());
    }
});

$app->run();