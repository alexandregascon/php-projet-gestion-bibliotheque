<?php

require_once "./vendor/autoload.php";
require "bootstrap.php";

$adherent=$entityManager->find(\App\Adherent::class,2);
$entityManager->remove($adherent);
$entityManager->flush();