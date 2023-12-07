# Création d'un adherent

Cette user story permet de créer un adherent dans la base de données.

## Création d'un Adherent

Une page [index.php](../index.php) a été créée pour
tester la création d'un adhrent.

### Ce que contient un Adherent

````php 
private int $idAdherent;
private string $numAdherent;
private string $prenom;
private string $nom;
private string $mail;
private \DateTime $dateAdhesion;
````

## A la création de l'Adherent

Les données insérées sont envoyées dans la base de données une fois vérifiées grâce à la
fonction execute qui se trouve dans le fichier
[CreerAdherent.php](../src/UserStories/CreerAdherent/CreerAdherent.php).

## Les vérifications

Les vérifications sont faites dans le fichier [CreerAdherentRequete.php](../src/UserStories/CreerAdherent/CreerAdherentRequete.php) avec les attributs
du validateur comme :

````php
#[Assert\NotBlank (
        message : "Message d'erreur"
    )]

    ou

#[Assert\Email(
        message : "Message d'erreur"
    )]
````
Elles sont également faites avec les fichiers :
- [EmailExistant.php](../src/Services/EmailExistant.php) qui
vérifie que le mail de l'adherent n'existe pas déjà dans la base de données.
- [NumeroExistant.php](../src/Services/NumeroExistant.php) qui vérifie si le 
numéro générer aléatoirement par la classe 
- [GenerateurNumeroAdherent.php](../src/Services/GenerateurNumeroAdherent.php) 
n'existe pas déja dans la base de données

## Comment utiliser la User Story

Des tests d'intégration ou unitaire sont disponibles avec la commande `.\vendor\bin\phpunit Tests --testdox --color=always`