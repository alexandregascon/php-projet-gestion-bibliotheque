<?php

require "./vendor/autoload.php";

echo PHP_EOL;
echo "Tests : classe Emprunt";
echo PHP_EOL;


echo "Test : vérifier si l'emprunt est terminé";
echo PHP_EOL;

// Arrange

$emprunt1 = new \App\Emprunt();

// Act

$date = new DateTime();
$emprunt1->setDateRetour($date->format("d/m/Y"));
$resultat = $emprunt1->getDateRetour();

// Assertion

if($resultat == null){
echo "Test pas OK".PHP_EOL;
}else{
echo "Test OK".PHP_EOL;
}

echo PHP_EOL;


echo "Test : vérifier si l'emprunt est en retard";
echo PHP_EOL;

// Arrange

$emprunt2 = new \App\Emprunt();

// Act

$resultat = $emprunt2->empruntEnRetard();

// Assertion

if($resultat = 1){
echo "Test Ok".PHP_EOL;
}else{
echo "Test pas OK".PHP_EOL;
}