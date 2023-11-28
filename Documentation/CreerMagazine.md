# Création d'un magazine

#### Cette UserStory permet de créer un magazine dans la base de données.

## Contenu de la User Story

`En tant que` bibliothécaire

`Je veux` créer un magazine

`Afin de` le rendre accessible aux adhérents de la bibliothèque

## Critères d'acceptation

### Validation des données

Le titre, le numéro, la date de publication doivent être renseignés.

Le numéro doit être unique

### Enregistrement dans la base de données

Les informations du magazine doivent être correctement enregistrées dans la base de données.

### Messages d'erreurs

Des messages d'erreurs explicites doivent être retournés en cas d'informations manquantes ou incorrectes

## Comment utiliser la User Story

La création du magazine se fait dans le fichier [CreerMagazine.php](../src/UserStories/CreerMagazine/CreerMagazine.php) avec la méthode `execute`

Une commande a été créée dans le fichier [app.php](../style/app.php) pour
tester la création d'un magazine avec le commande `php .\style\app.php biblio:add:Magazine`.

## Les Constantes

Le fichier [StatutMedia.php](../src/StatutMedia.php) permet de gérer via des constantes les statuts possibles pour un media