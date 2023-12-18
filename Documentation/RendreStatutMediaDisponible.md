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

## Comment utiliser la User Story


La modification du média se fait via le fichier [RendreStatutMediaDisponible.php](../src/UserStories/RendreStatutMediaDisponible/RendreStatutMediaDisponible.php) avec la méthode `execute`


Une commande a été créée dans le fichier [app.php](../style/app.php) pour

tester la modification d'un média avec la commande `php .\style\app.php biblio:modify:StatutMedia`.


Des tests d'intégration ou unitaire sont disponibles avec la commande `.\vendor\bin\phpunit Tests --testdox --color=always`


Des constantes sont utilisées pour le statut du média, elles sont dans le fichier [StatutMedia.php](../src/StatutMedia.php)