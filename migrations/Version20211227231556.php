<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211227231556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD departement VARCHAR(180) NOT NULL, ADD adresse VARCHAR(180) NOT NULL, ADD soldecongã© INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C1765B63 ON user (departement)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C35F0816 ON user (adresse)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D649C1765B63 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649C35F0816 ON user');
        $this->addSql('ALTER TABLE user DROP departement, DROP adresse, DROP soldecongã©');
    }
}
