<?php

namespace App\Tests\Unitaires;

use App\Emprunt;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ClasseEmpruntTest extends TestCase
{
    #[test]
    public function empruntEnCours_EmpruntEnCours_True()
    {
        $emprunt = new Emprunt();
        $resultat = $emprunt->empruntEnCours();
        $this->assertTrue($resultat);
    }

    #[test]
    public function empruntEnRetard_EmpruntEnRetard_True()
    {
        $emprunt = new Emprunt();
        $emprunt->setDateRetourEstimee("12/06/2000");
        $resultat = $emprunt->empruntEnRetard();
        $this->assertTrue($resultat);
    }
}


