<?php

class Emprunt{
    private DateTime $dateEmrpunt;
    private DateTime $dateRetourEstimee;
    private DateTime $dateRetour;
    private Adherent $adherent;
    private \App\Medias $media;

    public function __construct()
    {
    }
}