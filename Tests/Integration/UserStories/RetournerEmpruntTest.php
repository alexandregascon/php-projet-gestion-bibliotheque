<?php

namespace App\Tests\Integration\UserStories;

use App\Adherent;
use App\Emprunt;
use App\Magazine;
use App\Media;
use App\Services\GenerateurNumeroAdherent;
use App\StatutMedia;
use App\UserStories\CreerAdherent\CreerAdherent;
use App\UserStories\CreerAdherent\CreerAdherentRequete;
use App\UserStories\CreerMagazine\CreerMagasine;
use App\UserStories\CreerMagazine\CreerMagazineRequete;
use App\UserStories\EmprunterMedia\EmprunterMedia;
use App\UserStories\RendreStatutMediaDisponible\RendreStatutMediaDisponible;
use App\UserStories\RetournerEmprunt\RetournerEmprunt;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RetournerEmpruntTest extends \PHPUnit\Framework\TestCase
{
    protected EntityManagerInterface $entityManager;
    protected ValidatorInterface $validateur;

    // Méthode exécutée avant chaque test
    protected function setUp(): void
    {
        echo "setup ---------------------------------------------------------";
        // Configuration de Doctrine pour les tests
        $config = ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__ . '/../../../src/'],
            true
        );

        // Configuration de la connexion à la base de données
        // Utilisation d'une base de données SQLite en mémoire
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'path' => ':memory:'
        ], $config);

        // Création de l'entity manager
        $this->entityManager = new EntityManager($connection, $config);
        $this->generateur = new GenerateurNumeroAdherent();
        // Création du valdateur
        $this->validateur = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->addDefaultDoctrineAnnotationReader()
            ->getValidator();
        // Création du schema de la base de données
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($metadata);
    }

    #[test]
    public function retournerEmprunt_ValeursCorrectes_True() {
        // Arrange
        $retournerEmprunt = new RetournerEmprunt($this->entityManager);
        $requeteMagazine = new CreerMagazineRequete("N°123", "Test", new \DateTime(),new \DateTime());
        $creerMagazine = new CreerMagasine($this->entityManager, $this->validateur);

        $requeteAdherent = new CreerAdherentRequete("Charles","Leclerc","charles@test.fr");
        $creerAdherent = new CreerAdherent($this->entityManager,$this->generateur,$this->validateur);

        $emprunterMedia = new EmprunterMedia($this->entityManager);

        $rendreMediaDisponible = new RendreStatutMediaDisponible($this->entityManager);

        $date = new \DateTime();

        // Act
        $creerMagazine->execute($requeteMagazine);
        $creerAdherent->execute($requeteAdherent);

        $repositoryMagazine = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repositoryMagazine->findOneBy(["id" => 1]);

        $rendreMediaDisponible->execute($magazine->getId());

        $repositoryMagazine = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repositoryMagazine->findOneBy(["id" => 1]);

        $repositoryAdherent = $this->entityManager->getRepository(Adherent::class);
        $adherent = $repositoryAdherent->findOneBy(["mail" => "charles@test.fr"]);

        $emprunterMedia->execute($magazine->getId(),$adherent->getNumAdherent());

        $repositoryEmprunt = $this->entityManager->getRepository(Emprunt::class);
        $emprunt = $repositoryEmprunt->findOneBy(["idEmprunt"=>1]);

        $resultat = $retournerEmprunt->execute($emprunt->getNumEmprunt());

        // Assert
        $this->assertTrue($resultat);
        $stautMedia = $this->entityManager->getRepository(Media::class)->findOneBy(["id"=>1])->getStatut();
        $this->assertEquals(StatutMedia::STATUT_DISPONIBLE,$stautMedia);
        $dateRetour = $this->entityManager->getRepository(Emprunt::class)->findOneBy(["idEmprunt"=>1])->getDateRetour()->format("d/m/Y");
        $this->assertEquals($date->format("d/m/Y"),$dateRetour);
    }

    #[test]
    public function retournerEmprunt_EmpruntDejaRestitue_Exception() {
        // Arrange
        $retournerEmprunt = new RetournerEmprunt($this->entityManager);
        $requeteMagazine = new CreerMagazineRequete("N°123", "Test", new \DateTime(),new \DateTime());
        $creerMagazine = new CreerMagasine($this->entityManager, $this->validateur);

        $requeteAdherent = new CreerAdherentRequete("Charles","Leclerc","charles@test.fr");
        $creerAdherent = new CreerAdherent($this->entityManager,$this->generateur,$this->validateur);

        $emprunterMedia = new EmprunterMedia($this->entityManager);

        $rendreMediaDisponible = new RendreStatutMediaDisponible($this->entityManager);

        // Act
        $this->expectException(\Exception::class);

        $creerMagazine->execute($requeteMagazine);
        $creerAdherent->execute($requeteAdherent);

        $repositoryMagazine = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repositoryMagazine->findOneBy(["id" => 1]);

        $rendreMediaDisponible->execute($magazine->getId());

        $repositoryMagazine = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repositoryMagazine->findOneBy(["id" => 1]);

        $repositoryAdherent = $this->entityManager->getRepository(Adherent::class);
        $adherent = $repositoryAdherent->findOneBy(["mail" => "charles@test.fr"]);

        $emprunterMedia->execute($magazine->getId(),$adherent->getNumAdherent());

        $repositoryEmprunt = $this->entityManager->getRepository(Emprunt::class);
        $emprunt = $repositoryEmprunt->findOneBy(["idEmprunt"=>1]);

        $retournerEmprunt->execute($emprunt->getNumEmprunt());

        $repositoryEmprunt = $this->entityManager->getRepository(Emprunt::class);
        $emprunt = $repositoryEmprunt->findOneBy(["idEmprunt"=>1]);

        $retournerEmprunt->execute($emprunt->getNumEmprunt());
    }

    #[test]
    public function retournerEmprunt_NumEmpruntInexistant_Exception() {
        // Arrange
        $retournerEmprunt = new RetournerEmprunt($this->entityManager);
        $requeteMagazine = new CreerMagazineRequete("N°123", "Test", new \DateTime(),new \DateTime());
        $creerMagazine = new CreerMagasine($this->entityManager, $this->validateur);

        $requeteAdherent = new CreerAdherentRequete("Charles","Leclerc","charles@test.fr");
        $creerAdherent = new CreerAdherent($this->entityManager,$this->generateur,$this->validateur);

        $emprunterMedia = new EmprunterMedia($this->entityManager);

        $rendreMediaDisponible = new RendreStatutMediaDisponible($this->entityManager);

        // Act
        $this->expectException(\Exception::class);

        $creerMagazine->execute($requeteMagazine);
        $creerAdherent->execute($requeteAdherent);

        $repositoryMagazine = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repositoryMagazine->findOneBy(["id" => 1]);

        $rendreMediaDisponible->execute($magazine->getId());

        $repositoryMagazine = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repositoryMagazine->findOneBy(["id" => 1]);

        $repositoryAdherent = $this->entityManager->getRepository(Adherent::class);
        $adherent = $repositoryAdherent->findOneBy(["mail" => "charles@test.fr"]);

        $emprunterMedia->execute($magazine->getId(),$adherent->getNumAdherent());

        $retournerEmprunt->execute("EM-0");
    }
}