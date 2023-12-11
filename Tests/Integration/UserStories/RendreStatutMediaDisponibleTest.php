<?php

namespace Integration\UserStories;

use App\Media;
use App\StatutMedia;
use App\UserStories\CreerLivre\CreerLivre;
use App\UserStories\CreerLivre\CreerLivreRequete;
use App\UserStories\RendreStatutMediaDisponible\RendreStatutMediaDisponible;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RendreStatutMediaDisponibleTest extends \PHPUnit\Framework\TestCase
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
    public function StatutMedia_ValeurNouveau_True() {
        // Arrange
        $requete = new CreerLivreRequete("123-124-852","Leclerc",125,"Oui",new \DateTime());
        $creerLivre = new CreerLivre($this->entityManager,$this->validateur);

        // Act
        $resultat = $creerLivre->execute($requete);

        // Assert
        $repository = $this->entityManager->getRepository(Media::class);
        $media = $repository->findOneBy(["id" => "1"]);
        $this->assertEquals("Nouveau",$media->getStatut());
    }

    #[test]
    public function StatutMedia_ValeurDisponible_True() {
        // Arrange
        $requete = new CreerLivreRequete("123-124-852","Leclerc",125,"Oui",new \DateTime());
        $creerLivre = new CreerLivre($this->entityManager,$this->validateur);

        // Act
        $resultat = $creerLivre->execute($requete);

        // Assert
        $repository = $this->entityManager->getRepository(Media::class);
        $media = $repository->findOneBy(["id" => "1"]);
        $stautDispo = new RendreStatutMediaDisponible($this->entityManager);
        $stautDispo->execute(1);
        $this->assertEquals(StatutMedia::STATUT_DISPONIBLE,$media->getStatut());
    }

    #[test]
    public function StatutMedia_ValeurDeDepartDifferenteDeNouveau_Exception() {
        // Arrange
        $requete = new CreerLivreRequete("123-124-852","Leclerc",125,"Oui",new \DateTime());
        $creerLivre = new CreerLivre($this->entityManager,$this->validateur);

        // Act
        $resultat = $creerLivre->execute($requete);
        $this->expectException(\Exception::class);

        // Assert
        $stautDispo = new RendreStatutMediaDisponible($this->entityManager);
        $stautDispo->execute(1);
        $stautDispo = new RendreStatutMediaDisponible($this->entityManager);
        $stautDispo->execute(1);
    }

    #[test]
    public function StatutMedia_MediaInexistant_Exception() {

        $this->expectException(\Exception::class);

        $stautDispo = new RendreStatutMediaDisponible($this->entityManager);
        $stautDispo->execute(1);
    }
}