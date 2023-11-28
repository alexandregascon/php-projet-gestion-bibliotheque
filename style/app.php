<?php

require_once "vendor/autoload.php";
require "bootstrap.php";

use PHPUnit\Logging\Exception;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Console\Helper\Table;

// Définir les commandes

$app = new \Silly\Application();

$app->command("biblio:get:NewMedias",function(SymfonyStyle $io, OutputInterface $output) use ($entityManager) {
    $io->title("Liste des nouveaux médias");
    $listeMedia = new App\UserStories\ListerNouveauxMedias\ListerNouveauxMedias($entityManager);
    $medias = $listeMedia->execute();
    $table = new Table($output);
    $table2 = new Table($output);
    $table->setHeaders(["test1","test2","test3"]);
    $table->setRows([]);
    $table2->render();
});


$app->command("biblio:add:Magazine",function(SymfonyStyle $io) use ($entityManager) {

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

$app->command("biblio:add:Magazine:test",function(SymfonyStyle $io) use ($entityManager) {

    $io->title("Créer un magazine : ");
    $titre = $io->ask("Saisir le titre : ");

    $num = $io->ask("Saisir le numéro : ");

    $datePublication = $io->ask("Saisir la date de publication : ");

    $date = new DateTime($datePublication);

    $requete = [$titre,$num,$datePublication];

    $erreurs = $this->validateur->validate($requete);
    if (count($erreurs) > 0) {
        foreach ($erreurs as $erreur){
            $resultat = [$erreur->getMessage()];
        }
        throw new Exception($resultat[0]);
    }


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

$app->command("biblio:add:Livre",function(SymfonyStyle $io) use ($entityManager) {

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
    while ($nbPages == null or !is_numeric($nbPages)){
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