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
    $table->setHeaderTitle("Liste des nouveaux médias");
    $table->setHeaders(["test1","test2","test3","test4","test5"]);
    foreach ($medias as $media) {
        $table->addRow([$media["id"],$media["titre"],$media["statut"],$media["dateCreation"]->format("d/m/Y"),$media["type"]]);
    }
    $table->render();
});


$app->command("biblio:add:Magazine",function(SymfonyStyle $io) use ($entityManager) {

    $io->title("Créer un magazine : ");
    $titre = $io->ask("Saisir le titre : ");
    if($titre == null){
        $titre = "";
    }
    $num = $io->ask("Saisir le numéro : ");
    if($num == null){
        $num = "";
    }
    $datePublication = $io->ask("Saisir la date de publication : ");
    if($datePublication == null){
        $date = "";
    }else{
        $date = new DateTime($datePublication);
    }


    // Création du valdateur
    $validateur = Validation::createValidatorBuilder()
        ->enableAnnotationMapping()
        ->addDefaultDoctrineAnnotationReader()
        ->getValidator();

    $requete = new \App\UserStories\CreerMagazine\CreerMagazineRequete($num, $titre, new DateTime(), $date);
    $creerMagazine = new \App\UserStories\CreerMagazine\CreerMagasine($entityManager, $validateur);
    try{
        $creerMagazine->execute($requete);
    }catch(\Exception $e){
        $erreurs = $e->getMessage();
        $io->error(explode("SE",$erreurs));
        dd();
    }
    $io->success("Création dans la base de données effectuée");
});

$app->command("biblio:modify:StatutMedia",function(SymfonyStyle $io) use ($entityManager) {
    $io->title("Modifier le statut d'un média");
    $id = $io->ask("Saisir l'id du média à modifier");
    try{
        $rendreStatutDispo = new \App\UserStories\RendreStatutMediaDisponible\RendreStatutMediaDisponible($entityManager);
        $rendreStatutDispo->execute($id);
        $io->success("Modification dans la base de données effectuée");
    }catch(\Exception $e){
        $erreur = $e->getMessage();
        $io->error($erreur);
    }
});

$app->command("biblio:add:Livre",function(SymfonyStyle $io) use ($entityManager) {

    $io->title("Créer un livre : ");

    $titre = $io->ask("Saisir le titre : ");
    if($titre == null){
        $titre = "";
    }
    $isbn = $io->ask("Saisir l'isbn : ");
    if($isbn == null){
        $isbn = "";
    }
    $auteur = $io->ask("Saisir le nom de l'auteur : ");
    if($auteur == null){
        $auteur = "";
    }
    $nbPages = $io->ask("Saisir le nombre de pages : ");
    if($nbPages == null){
        $nbPages = -1;
    }
    // Création du valdateur
    $validateur = Validation::createValidatorBuilder()
        ->enableAnnotationMapping()
        ->addDefaultDoctrineAnnotationReader()
        ->getValidator();

    $requete = new \App\UserStories\CreerLivre\CreerLivreRequete($isbn,$auteur,$nbPages,$titre,new DateTime());
    $creerLivre = new \App\UserStories\CreerLivre\CreerLivre($entityManager, $validateur);

    try{
        $creerLivre->execute($requete);
    }catch(\Exception $e){
        $erreurs = $e->getMessage();
        $io->error(explode("SE",$erreurs));
        dd();
    }
    $io->success("Création dans la base de données effectuée");
});

$app->command("biblio:add:Emprunt",function(SymfonyStyle $io) use ($entityManager) {

    $io->title("Détail de l'emprunt : ");

    $media = $io->ask("Saisir l'id du média : ");
    if($media == null){
        $media = -1;
    }

    $adherent = $io->ask("Saisir le numéro de l'adhérent : ");
    if($adherent == null){
        $adherent = "Erreur";
    }

    $emprunterMedia = new \App\UserStories\EmprunterMedia\EmprunterMedia($entityManager);

    try{
        $emprunterMedia->execute($media,$adherent);
    }catch(\Exception $e){
        $erreurs = $e->getMessage();
        $io->error($erreurs);
        dd();
    }
    $io->success("Création dans la base de données effectuée");
});

$app->run();