<?php

class BluRay extends \App\Medias{
    private string $realisateur;
    private string $duree;
    private string $anneeSortie;
    private int $dureeEmprunt;

    public function __construct()
    {
        parent::__construct();
    }
}