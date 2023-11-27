<?php

require "vendor/autoload.php";

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// Définir les commandes

$app = new \Silly\Application();
$app->command('greet [name] [--yell]', function ($name, $yell, OutputInterface $output) {
    $text = $name ? "Hello, $name" : "Hello";

    if ($yell) {
        $text = strtoupper($text);
    }

    $output->writeln($text);
});

$app->command("test",function(SymfonyStyle $io){
    $io->title("Commande test");
    $io->text("Commande test");
    $io->note("Commande test");
    $io->error("Erreur Commande test");
    $prenom = $io->ask("Saisir votre prénom : ");
    $io->writeln($prenom);
    $choice = $io->choice("Choisir une valeur : ",["Val1","Val2","Val3"]);
    $io->writeln($choice);
    $io->success("Commande exécutée avec succes");
});

$app->run();