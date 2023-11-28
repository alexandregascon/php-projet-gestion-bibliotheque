<?php

use App\Services\GenerateurNumeroAdherent;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Validator\Validation;

require_once "vendor/autoload.php";
require "bootstrap.php";


if(isset($_POST) and $_POST){

    // Création du générateur
    $generateur = new GenerateurNumeroAdherent();
    // Création du valdateur
    $validateur = Validation::createValidatorBuilder()
        ->enableAnnotationMapping()
        ->addDefaultDoctrineAnnotationReader()
        ->getValidator();

    try {
        $requete = new \App\UserStories\CreerAdherent\CreerAdherentRequete($_POST["prenom"],$_POST["nom"],$_POST["mail"]);
        $creerAdherent = new \App\UserStories\CreerAdherent\CreerAdherent($entityManager, $generateur, $validateur);
        $creerAdherent->execute($requete);
    }catch (Exception $e){
        $erreur = $e->getMessage();
    }
}

?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Création Adherent</title>
</head>
<body>
    <h1>Créer un adherent</h1>
    <form action="" method="post">
        <label for="prenom">Entrer le prénom : </label>
        <input type="text" name="prenom" id="prenom">

        <label for="nom">Entrer le nom : </label>
        <input type="text" name="nom" id="nom">

        <label for="mail">Entrer le mail : </label>
        <input type="text" name="mail" id="mail">

        <input type="submit" value="Créer">
    </form>

<?php if(isset($erreur)){ ?>
    <p> <?= $erreur ?> </p>
<?php } ?>
</body>
</html>