<?php

namespace Integration\UserStories;

use App\Services\GenerateurNumeroAdherent;
use App\UserStories\CreerLivre\CreerLivre;
use App\UserStories\CreerLivre\CreerLivreRequete;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ListerNouveauxMediasTest extends TestCase
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
    public function listerNouveauxMedias_ValeursRecuperer_True() {
        // Arrange
        $requete = new CreerLivreRequete("123-456-789","Pierre",150,"Test",new \DateTime());
        $creerLivre = new CreerLivre($this->entityManager,$this->validateur);
        // Act
        $resultat = $creerLivre->execute($requete);

        // Assert
        $listerMedias = new \App\UserStories\ListerNouveauxMedias\ListerNouveauxMedias($this->entityManager);
        $medias = $listerMedias->execute();
        $this->assertNotNull($medias);
    }

    #[test]
    public function listerNouveauxMedias_ValeursRecuperer_Null() {

        // Assert
        $listerMedias = new \App\UserStories\ListerNouveauxMedias\ListerNouveauxMedias($this->entityManager);
        $medias = $listerMedias->execute();
        $this->assertNull($medias);
    }
}