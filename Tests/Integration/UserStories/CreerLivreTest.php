<?php

namespace Tests\Integration\UserStories;

include_once "src/Services/EmailExistant.php";

use App\Adherent;
use App\Livre;
use App\Services\EmailExistant;
use App\Services\GenerateurNumeroAdherent;
use App\Services\IsbnExistant;
use App\Services\NumeroExistant;
use App\UserStories\CreerAdherent\CreerAdherent;
use App\UserStories\CreerAdherent\CreerAdherentRequete;
use App\UserStories\CreerLivre\CreerLivre;
use App\UserStories\CreerLivre\CreerLivreRequete;
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

class CreerLivreTest extends TestCase
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
    public function creerLivre_ValeursCorrectes_True() {
        // Arrange
        $requete = new CreerLivreRequete("123-456-789","Pierre",150,"Test",new \DateTime());
        $creerLivre = new CreerLivre($this->entityManager,$this->validateur);

        // Act
        $resultat = $creerLivre->execute($requete);

        // Assert
        $repository = $this->entityManager->getRepository(Livre::class);
        $livre = $repository->findOneBy(["isbn" => "123-456-789"]);
        $this->assertNotNull($livre);
        $this->assertEquals("123-456-789",$livre->getIsbn());
        $this->assertEquals("Pierre",$livre->getAuteur());
    }

    #[test]
    public function creerLivre_TitreVide_Violation()
    {
        // Arrange
        $requete = new CreerLivreRequete("123-456-888", "Leclerc", 120,"",new \DateTime());
        $creerLivre = new CreerLivre($this->entityManager, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat = $creerLivre->execute($requete);
    }

    #[test]
    public function creerLivre_IsbnVide_Violation()
    {
        // Arrange
        $requete = new CreerLivreRequete("", "Leclerc", 120,"Test",new \DateTime());
        $creerLivre = new CreerLivre($this->entityManager, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat = $creerLivre->execute($requete);
    }

    #[test]
    public function creerLivre_AuteurVide_Violation()
    {
        // Arrange
        $requete = new CreerLivreRequete("123-455-555", "", 120,"Test",new \DateTime());
        $creerLivre = new CreerLivre($this->entityManager, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat = $creerLivre->execute($requete);
    }

    #[test]
    public function creerLivre_IsbnDejaExistant_Exception()
    {
        // Arrange
        $requete = new CreerLivreRequete("123-456-789", "Leclerc", 120,"Test1",new \DateTime());
        $requete2 = new CreerLivreRequete("123-456-789", "Gasly", 130,"Test2",new \DateTime());
        $creerLivre = new CreerLivre($this->entityManager, $this->validateur);

        // Act
        $this->expectException(\Exception::class);
        $resultat1 = $creerLivre->execute($requete);
        $isbnVerif = new IsbnExistant();
        $isbnVerif->verifier($requete2,$this->entityManager);
        $resultat2 = $creerLivre->execute($requete2);
    }

}