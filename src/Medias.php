<?php

namespace App;

abstract class Medias{

    protected int $idMedia;
    protected string $titre;
    protected string $statut;
    protected \DateTime $dateCreation;

    public function __construct(){
    }

}