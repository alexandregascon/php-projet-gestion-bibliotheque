<?php

class Magazine extends \App\Medias{
    private string $num;
    private DateTime $datePublication;
    private int $dureeEmprunt;

    public function __construct()
    {
        parent::__construct();
    }
}