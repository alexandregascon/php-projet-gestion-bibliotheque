<?php

require_once "./vendor/autoload.php";
require "bootstrap.php";



$adherent = new \App\Adherent();
$adherent->setNumAdherent("AD-986531");
$adherent->setPrenom("Estebane");
$adherent->setNom("Ocon");
$adherent->setMail("test@mail.com");
$adherent->setDateAdhesion("2022");
$entityManager->persist($adherent);
$entityManager->flush();