<?php

require_once "./vendor/autoload.php";
require "bootstrap.php";


$infos = $entityManager->getRepository(\App\Adherent::class)->find(5);
dump($infos);
echo PHP_EOL;
$infosAll = $entityManager->getRepository(\App\Adherent::class)->findAll();
dump($infosAll);
