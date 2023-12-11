# Rendre le statut d'un média à "Disponible"

### Cette UserStory permet de modifier le statut d'un media pour le rendre "Disponible" si il est au statut "Nouveau"

#### L'accès au média à rendre disponible se fait via son id

## Contenu de la User Story

`En tant que` bibliothécaire

`Je veux` rendre disponible un nouveau média

`Afin de` le rendre empruntable par les adhérents de la bibliothèque

### Crières d'accepation

#### Média existe

Le média que l'on souhaite rendre disponible doit exister

#### Statut du média

Seul un média ayant le statut "Nouveau" peut-être rendu disponible

#### Enregistrement dans la base de données

Le changement de statut du média est correctement enregistré dans la base de données

### Messages d'erreurs

Des messages d'erreurs explicites doivent être retournés en cas d'informations manquantes ou incorrectes

[//]: # (## Comment utiliser la User Story)

[//]: # ()
[//]: # (La récupèration des nouveaux médias se fait via le fichier [ListerNouveauxMedias.php]&#40;../src/UserStories/ListerNouveauxMedias/ListerNouveauxMedias.php&#41; avec la méthode `execute`)

[//]: # ()
[//]: # (Une commande a été créée dans le fichier [app.php]&#40;../style/app.php&#41; pour)

[//]: # (tester le listage des nouveaux médias avec le commande `php .\style\app.php biblio:get:NewMedias`.)

[//]: # ()
[//]: # (Des tests d'intégration ou unitaire sont disponibles avec la commande `.\vendor\bin\phpunit Tests --testdox --color=always`)

[//]: # ()
[//]: # (## Fonctions abstraites)

[//]: # ()
[//]: # (Une fonction abstraite `getType` a été créée dans chaque sous-classe de Média :)

[//]: # (- [Livre.php]&#40;../src/Livre.php&#41;)

[//]: # (- [Magazine.php]&#40;../src/Magazine.php&#41;)

[//]: # (- [BluRay.php]&#40;../src/BluRay.php&#41;)

[//]: # ()
[//]: # (Elle permet de récupérer le type du média qui n'est pas récupérable directement depuis la BDD)