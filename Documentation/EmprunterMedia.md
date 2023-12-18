# Emprunt d'un média

#### Cette UserStory permet d'Emprunter un média

## Contenu de la User Story

`En tant que` bibliothécaire

`Je veux` enregistrer un emprunt de média disponible pour un adhérent

`Afin de` permettre à l'adhérent d'utiliser ce média pour une durée déterminée

## Critères d'acceptation

### Validation des données

#### Média

- Le média doit exister dans la base de données
- Le média doit être disponible

#### Adhérent

- L'adhérent doit exister dans la base de données
- L'adhésion de l'adhérent doit être valide

### Enregistrement dans la base de données

L'emprunt est enregistré dans la base de données avec les bonnes informations, avec la date de retour prévue correctement initialisée en fonction du média emprunté ainsi que la date d'emprunt

### Messages d'erreurs

Des messages d'erreurs explicites sont retournés en cas d'informations manquantes ou incorrectes

## Comment utiliser la User Story

L'emprunt d'un média se fait dans le fichier [EmprunterMedia.php](../src/UserStories/EmprunterMedia/EmprunterMedia.php) avec la méthode `execute`

Une commande a été créée dans le fichier [app.php](../style/app.php) pour
tester l'emprunt d'un média avec le commande `php .\style\app.php biblio:add:Emprunt`.

Des tests d'intégration ou unitaire sont disponibles avec la commande `.\vendor\bin\phpunit Tests --testdox --color=always`

## Les Constantes

Le fichier [StatutMedia.php](../src/StatutMedia.php) permet de gérer via des constantes les statuts possibles pour un media