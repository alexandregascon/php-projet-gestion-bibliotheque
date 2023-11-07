<?php

namespace Tests\Integration\UserStories;

use App\Adherent;
use App\Services\GenerateurNumeroAdherent;
use App\UserStories\CreerAdherent\CreerAdherent;
use App\UserStories\CreerAdherent\CreerAdherentRequete;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
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
        $this->validateur = (new ValidatorBuilder())->enableAnnotationMapping()->getValidator();

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
}