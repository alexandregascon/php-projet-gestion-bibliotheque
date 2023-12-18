<?php

namespace Integration\UserStories;

use App\Adherent;
use App\Emprunt;
use App\Livre;
use App\Magazine;
use App\Services\GenerateurNumeroAdherent;
use App\UserStories\CreerAdherent\CreerAdherent;
use App\UserStories\CreerAdherent\CreerAdherentRequete;
use App\UserStories\CreerMagazine\CreerMagasine;
use App\UserStories\CreerMagazine\CreerMagazineRequete;
use App\UserStories\EmprunterMedia\EmprunterMedia;
use App\UserStories\RendreStatutMediaDisponible\RendreStatutMediaDisponible;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmprunterMediaTest extends TestCase
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
    public function emprunterMedia_ValeursCorrectes_True() {
        // Arrange
        $emprunterMedia = new EmprunterMedia($this->entityManager);

        $requeteMagazine = new CreerMagazineRequete("N°123", "Test", new \DateTime(),new \DateTime());
        $creerMagazine = new CreerMagasine($this->entityManager, $this->validateur);

        $requeteAdherent = new CreerAdherentRequete("Charles","Leclerc","charles@test.fr");
        $creerAdherent = new CreerAdherent($this->entityManager,$this->generateur,$this->validateur);

        $rendreStatutDispo = new RendreStatutMediaDisponible($this->entityManager);

        // Act
        $creerMagazine->execute($requeteMagazine);
        $creerAdherent->execute($requeteAdherent);

        $repositoryMagazine = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repositoryMagazine->findOneBy(["num" => "N°123"]);

        $rendreStatutDispo->execute($magazine->getId());
        $repositoryMagazine = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repositoryMagazine->findOneBy(["num" => "N°123"]);

        $repositoryAdherent = $this->entityManager->getRepository(Adherent::class);
        $adherent = $repositoryAdherent->findOneBy(["mail" => "charles@test.fr"]);

        $resultat = $emprunterMedia->execute($magazine->getId(),$adherent->getNumAdherent());

        // Assert
        $this->assertTrue($resultat);
    }
    #[test]
    public function emprunterMedia_MediaInexistant_Exception() {
        // Arrange
        $emprunterMedia = new EmprunterMedia($this->entityManager);

        $requeteAdherent = new CreerAdherentRequete("Charles","Leclerc","charles@test.fr");
        $creerAdherent = new CreerAdherent($this->entityManager,$this->generateur,$this->validateur);


        // Act
        $this->expectException(\Exception::class);
        $creerAdherent->execute($requeteAdherent);

        $repositoryAdherent = $this->entityManager->getRepository(Adherent::class);
        $adherent = $repositoryAdherent->findOneBy(["mail" => "charles@test.fr"]);

        $resultat = $emprunterMedia->execute(1,$adherent->getNumAdherent());
    }
    #[test]
    public function emprunterMedia_AdherentInexistant_Exception() {
        // Arrange
        $emprunterMedia = new EmprunterMedia($this->entityManager);

        $requeteMagazine = new CreerMagazineRequete("N°123", "Test", new \DateTime(),new \DateTime());
        $creerMagazine = new CreerMagasine($this->entityManager, $this->validateur);

        $rendreStatutDispo = new RendreStatutMediaDisponible($this->entityManager);

        // Act
        $this->expectException(\Exception::class);
        $creerMagazine->execute($requeteMagazine);

        $repositoryMagazine = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repositoryMagazine->findOneBy(["num" => "N°123"]);

        $rendreStatutDispo->execute($magazine->getId());
        $repositoryMagazine = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repositoryMagazine->findOneBy(["num" => "N°123"]);

        $resultat = $emprunterMedia->execute($magazine->getId(),"Test");
    }

}