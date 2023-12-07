# Affichage des nouveaux Medias

#### Cette UserStory permet de lister tout les Média qui sont au statut "Nouveau"

## Contenu de la User Story

`En tant que` bibliothécaire

`Je veux` lister les nouveaux médias

`Afin de` les rendre disponibles aux adhérents de la bibliothèque

### Crières d'accepation

Les valeurs retournées sont :
- l'id du média
- le titre du média
- la statut du média
- la date de création du média (date à laquelle il a été créé dans la BDD)
- le type du média (livre,bluray ou magazine)

Les valeurs retournées seront triées par ordre décroissante par rapport à la date de création

### Messages d'erreurs

Des messages d'erreurs explicites doivent être retournés en cas d'informations manquantes ou incorrectes

## Comment utiliser la User Story

La récupèration des nouveaux médias se fait via le fichier [ListerNouveauxMedias.php](../src/UserStories/ListerNouveauxMedias/ListerNouveauxMedias.php) avec la méthode `execute`

Une commande a été créée dans le fichier [app.php](../style/app.php) pour
tester le listage des nouveaux médias avec le commande `php .\style\app.php biblio:get:NewMedias`.

Des tests d'intégration ou unitaire sont disponibles avec la commande `.\vendor\bin\phpunit Tests --testdox --color=always`

## Fonctions abstraites

Une fonction abstraite `getType` a été créée dans chaque sous-classe de Média :
- [Livre.php](../src/Livre.php)
- [Magazine.php](../src/Magazine.php)
- [BluRay.php](../src/BluRay.php)

Elle permet de récupérer le type du média qui n'est pas récupérable directement depuis la BDD