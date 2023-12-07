# Création d'un livre

#### Cette UserStory permet de créer un livre dans la base de données.

## Contenu de la User Story

`En tant que` bibliothécaire

`Je veux` créer un livre

`Afin de` le rendre accessible aux adhérents de la bibliothèque

## Critères d'acceptation

### Validation des données

Le titre, l'ISBN, l'auteur, le nombre de pages et la date de parution doivent être renseignés.

L'ISBN doit être unique

### Enregistrement dans la base de données

Les informations du livre doivent être correctement enregistrées dans la base de données.

### Messages d'erreurs

Des messages d'erreur explicites doivent être retournés en cas d'informations manquantes ou incorrectes

### Cas du statut et de la duré de l'emprunt

- Le statut par défaut lors de la création d'un livre devra être 'Nouveau'
- La durée de l'emprunt devra être égale à la durée définie lors de la présentation du projet

## Comment utiliser la User Story

La création du livre se fait dans le fichier [CréerLivre.php](../src/UserStories/CreerLivre/CreerLivre.php) avec la méthode `execute`

Une commande a été créée dans le fichier [app.php](../style/app.php) pour
tester la création d'un livre avec le commande `php .\style\app.php biblio:add:Livre`.

Des tests d'intégration ou unitaire sont disponibles avec la commande `.\vendor\bin\phpunit Tests --testdox --color=always`

## Les Constantes

Le fichier [StatutMedia.php](../src/StatutMedia.php) permet de gérer via des constantes les statuts possibles pour un media