<?php

require_once "vendor/autoload.php";
require "bootstrap.php";

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validation;

// Définir les commandes

$app = new \Silly\Application();

$app->command("showNewMedias",function(SymfonyStyle $io) use ($entityManager) {
    $io->title("Liste des nouveaux médias");
    $medias = $entityManager->getRepository(\App\Media::class)->findBy(["statut"=>"Nouveau"]);
        $io->table(["1","2"],[$medias]);
});


$app->command("creerMagazine",function(SymfonyStyle $io) use ($entityManager) {

    $io->title("Créer un magazine : ");
    $titre = $io->ask("Saisir le titre : ");
    while ($titre == null) {
        $io->error("Il faut un titre");
        $titre = $io->ask("Saisir le titre : ");
    }
    $num = $io->ask("Saisir le numéro : ");
    while ($num == null){
        $io->error("Il faut un numéro");
        $num = $io->ask("Saisir le numéro : ");
    }
    $datePublication = $io->ask("Saisir la date de publication : ");
    while ($datePublication == null){
        $io->error("Il faut une date de publication");
        $datePublication = $io->ask("Saisir la date de publication : ");
    }
    $date = new DateTime($datePublication);

    // Création du valdateur
    $validateur = Validation::createValidatorBuilder()
        ->enableAnnotationMapping()
        ->addDefaultDoctrineAnnotationReader()
        ->getValidator();

    $requete = new \App\UserStories\CreerMagazine\CreerMagazineRequete($num, $titre, new DateTime(), $date);
    $creerMagazine = new \App\UserStories\CreerMagazine\CreerMagasine($entityManager, $validateur);
    $creerMagazine->execute($requete);
    $io->success("Création dans la base de données effectuée");
});

$app->command("creerLivre",function(SymfonyStyle $io) use ($entityManager) {

    $io->title("Créer un livre : ");
    $titre = $io->ask("Saisir le titre : ");
    while ($titre == null){
        $io->error("Vous devez entrer une valeur pour le titre");
        $titre = $io->ask("Saisir le titre : ");
    }

    $isbn = $io->ask("Saisir l'isbn : ");
    while ($isbn == null){
        $io->error("Vous devez entrer une valeur pour l'isbn");
        $isbn = $io->ask("Saisir l'isbn : ");
    }

    $auteur = $io->ask("Saisir le nom de l'auteur : ");
    while ($auteur == null){
        $io->error("Vous devez entrer une valeur pour le nom de l'auteur");
        $auteur = $io->ask("Saisir le nom de l'auteur : ");
    }

    $nbPages = $io->ask("Saisir le nombre de pages : ");
    while ($nbPages == null){
        $io->error("Vous devez entrer une valeur pour le nombre de pages");
        $nbPages = $io->ask("Saisir le nombre de pages : ");
    }

    // Création du valdateur
    $validateur = Validation::createValidatorBuilder()
        ->enableAnnotationMapping()
        ->addDefaultDoctrineAnnotationReader()
        ->getValidator();

    $requete = new \App\UserStories\CreerLivre\CreerLivreRequete($isbn,$auteur,$nbPages,$titre,new DateTime());
    $creerLivre = new \App\UserStories\CreerLivre\CreerLivre($entityManager, $validateur);
    $creerLivre->execute($requete);
    $io->success("Création dans la base de données effectuée");
});

$app->run();