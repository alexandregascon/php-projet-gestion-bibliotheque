<?php

namespace Tests\Integration\UserStories;

include_once "src/Services/EmailExistant.php";

use App\Adherent;
use App\Services\EmailExistant;
use App\Services\GenerateurNumeroAdherent;
use App\Services\NumeroExistant;
use App\UserStories\CreerAdherent\CreerAdherent;
use App\UserStories\CreerAdherent\CreerAdherentRequete;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Logging\Exception;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

class CreerAdherentTest extends TestCase
{
    protected EntityManagerInterface $entityManager;
    protected GenerateurNumeroAdherent $generateur;
    protected ValidatorInterface $validateur;

    // Méthode exécutée avant chaque test
    protected function setUp() : void
    {
        echo "setup ---------------------------------------------------------";
        // Configuration de Doctrine pour les tests
        $config = ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__.'/../../../src/'],
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
        // Création du générateur
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
    public function creerAdherent_ValeursCorrectes_True() {
        // Arrange
        $requete = new CreerAdherentRequete("Charles","Leclerc","charles@test.fr");
        $creerAdherent = new CreerAdherent($this->entityManager,$this->generateur,$this->validateur);

        // Act
        $resultat = $creerAdherent->execute($requete);

        // Assert
        $repository = $this->entityManager->getRepository(Adherent::class);
        $adherent = $repository->findOneBy(["mail" => "charles@test.fr"]);
        $this->assertNotNull($adherent);
        $this->assertEquals("Charles",$adherent->getPrenom());
        $this->assertEquals("Leclerc",$adherent->getNom());
    }

    #[test]
    public function creerAdherent_PrenomVide_Exception()
    {
        // Arrange
        $requete = new CreerAdherentRequete("", "Leclerc", "charles@test.fr");
        $creerAdherent = new CreerAdherent($this->entityManager, $this->generateur, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat = $creerAdherent->execute($requete);
    }
    #[test]
    public function creerAdherent_NomVide_Exception()
    {
        // Arrange
        $requete = new CreerAdherentRequete("Charles", "", "charles@test.fr");
        $creerAdherent = new CreerAdherent($this->entityManager, $this->generateur, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat = $creerAdherent->execute($requete);
    }

    #[test]
    public function creerAdherent_EmailVide_Exception()
    {
        // Arrange
        $requete = new CreerAdherentRequete("Charles", "Leclerc", "");
        $creerAdherent = new CreerAdherent($this->entityManager, $this->generateur, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat = $creerAdherent->execute($requete);
    }

    #[test]
    public function creerAdherent_EmailIncorrrect_Exception()
    {
        // Arrange
        $requete = new CreerAdherentRequete("Charles", "Leclerc", "mauvaisEmail");
        $creerAdherent = new CreerAdherent($this->entityManager, $this->generateur, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat = $creerAdherent->execute($requete);
    }

    #[test]
    public function creerAdherent_EmailDejaExistant_Exception()
    {
        // Arrange
        $requete = new CreerAdherentRequete("Charles", "Leclerc", "Charles@test.fr");
        $requete2 = new CreerAdherentRequete("Pierre","Gasly","Charles@test.fr");
        $creerAdherent = new CreerAdherent($this->entityManager, $this->generateur, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat1 = $creerAdherent->execute($requete);
        $emailVerif = new EmailExistant();
        $emailVerif->verifier($requete2,$this->entityManager);
        $resultat2 = $creerAdherent->execute($requete2);
    }

    #[test]
    public function creerAdherent_EmailUnique_True()
    {
        // Arrange
        $requete = new CreerAdherentRequete("Charles", "Leclerc", "Charles@test.fr");
        $requete2 = new CreerAdherentRequete("Pierre","Gasly","Pierre@test.fr");
        $creerAdherent = new CreerAdherent($this->entityManager, $this->generateur, $this->validateur);

        // Act
        $resultat1 = $creerAdherent->execute($requete);
        $emailVerif = new EmailExistant();
        $verif = ($emailVerif->verifier($requete2,$this->entityManager));
        $resultat2 = $creerAdherent->execute($requete2);

        // Assert

        $this->assertTrue($verif);
    }

    #[test]
    public function creerAdherent_NumUnique_True()
    {
        // Arrange
        $numeroAdherent = "AD-123456";
        $adherent = new Adherent();
        $adherent->setNumAdherent($numeroAdherent);
        $adherent->setPrenom("Charles");
        $adherent->setNom("Leclerc");
        $adherent->setMail("Charles@test.fr");
        $adherent->setDateAdhesion(new \DateTime());
        // Enregistrer l'adhérent en base de données
        $this->entityManager->persist($adherent);
        $this->entityManager->flush();

        // Act
        $numVerif = new NumeroExistant();
        $verif = ($numVerif->verifier("AD-000000",$this->entityManager));

        // Assert

        $this->assertTrue($verif);
    }

    #[test]
    public function creerAdherent_NumExistant_False()
    {
        // Arrange
        $numeroAdherent = "AD-123456";
        $adherent = new Adherent();
        $adherent->setNumAdherent($numeroAdherent);
        $adherent->setPrenom("Charles");
        $adherent->setNom("Leclerc");
        $adherent->setMail("Charles@test.fr");
        $adherent->setDateAdhesion(new \DateTime());
        // Enregistrer l'adhérent en base de données
        $this->entityManager->persist($adherent);
        $this->entityManager->flush();

        // Act
        $numVerif = new NumeroExistant();
        $numVerif = $numVerif->verifier("AD-123456",$this->entityManager);

        // Assert

        $this->assertFalse($numVerif);
    }
}