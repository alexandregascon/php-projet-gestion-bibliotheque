<?php

use App\Medias;

class Livre extends Medias{
    private string $isbn;
    private string $auteur;
    private int $nbPages;
    private int $dureeEmprunt;

    public function __construct()
    {
        parent::__construct();
    }
}