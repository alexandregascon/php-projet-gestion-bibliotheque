<?php

namespace App\Services;

class GenerateurNumeroAdherent
{
    public function generer(): string
    {
        return "AD-".random_int(1,9).random_int(1,9).random_int(1,9).random_int(1,9).random_int(1,9).random_int(1,9);
    }
}