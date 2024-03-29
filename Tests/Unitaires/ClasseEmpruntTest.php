<?php

namespace App\Tests\Unitaires;

use App\Adherent;
use App\Emprunt;
use App\Livre;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSize\Medium;
use PHPUnit\Logging\Exception;

class ClasseEmpruntTest extends TestCase
{
    #[test]
    public function empruntEnCours_EmpruntEnCours_False()
    {
        $emprunt1 = new Emprunt();
        $resultat1 = $emprunt1->empruntRendu();
        $this->assertFalse($resultat1);
    }

    #[test]
    public function empruntEnCours_EmpruntEnCours_True()
    {
        $emprunt2 = new Emprunt();
        $emprunt2->setDateRetour("01/01/2050");
        $resultat2 = $emprunt2->empruntRendu();
        $this->assertTrue($resultat2);
    }

    #[test]
    public function empruntEnRetard_EmpruntEnRetard_True()
    {
        $emprunt3 = new Emprunt();
        $emprunt3->setDateRetourEstimee("01/06/2001");
        $resultat3 = $emprunt3->empruntEnRetard();
        $this->assertTrue($resultat3);
    }

    #[test]
    public function empruntEnRetard_EmpruntEnRetard_False()
    {
        $emprunt4 = new Emprunt();
        $emprunt4->setDateRetourEstimee("01/06/2050");
        $this->expectException(\Exception::class);
        $emprunt4->empruntEnRetard();

    }

    #[test]
    public function empruntEnRetard_EmpruntRendu_False()
    {
        $emprunt5 = new Emprunt();
        $emprunt5->setDateRetour("01/01/2020");
        $emprunt5->setDateRetourEstimee("01/06/2020");
        $this->expectException(\Exception::class);
        $emprunt5->empruntEnRetard();
    }

}

