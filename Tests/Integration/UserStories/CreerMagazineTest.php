<?php

namespace Integration\UserStories;

include_once "src/Services/EmailExistant.php";

use App\Magazine;
use App\Services\NumMagazineExistant;
use App\UserStories\CreerMagazine\CreerMagasine;
use App\UserStories\CreerMagazine\CreerMagazineRequete;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreerMagazineTest extends TestCase
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
    public function creerMagazine_ValeursCorrectes_True() {
        // Arrange
        $requete = new CreerMagazineRequete("N°125","Test",new \DateTime(),new \DateTime());
        $creerMagazine = new CreerMagasine($this->entityManager,$this->validateur);

        // Act
        $resultat = $creerMagazine->execute($requete);

        // Assert
        $repository = $this->entityManager->getRepository(Magazine::class);
        $magazine = $repository->findOneBy(["num" => "N°125"]);
        $this->assertNotNull($magazine);
        $this->assertEquals("N°125",$magazine->getNum());
        $this->assertEquals("Test",$magazine->getTitre());
    }

    #[test]
    public function creerMagazine_TitreVide_Violation()
    {
        // Arrange
        $requete = new CreerMagazineRequete("N°124", "", new \DateTime(),new \DateTime());
        $creerMagazine = new CreerMagasine($this->entityManager, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat = $creerMagazine->execute($requete);
    }

    #[test]
    public function creerMagazine_NumVide_Violation()
    {
        // Arrange
        $requete = new CreerMagazineRequete("", "Test", new \DateTime(),new \DateTime());
        $creerMagazine = new CreerMagasine($this->entityManager, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat = $creerMagazine->execute($requete);
    }


    #[test]
    public function creerMagazine_NumDejaExistant_Exception()
    {
        // Arrange
        $requete = new CreerMagazineRequete("N°125", "Test1", new \DateTime(),new \DateTime());
        $requete2 = new CreerMagazineRequete("N°125", "Test2", new \DateTime(),new \DateTime());
        $creerMagazine = new CreerMagasine($this->entityManager, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat1 = $creerMagazine->execute($requete);
        $numVerif = new NumMagazineExistant();
        $numVerif->verifier($requete2,$this->entityManager);
        $resultat2 = $creerMagazine->execute($requete2);
    }

}