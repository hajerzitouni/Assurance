<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210727211952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE authorization (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, validate_by_id INT DEFAULT NULL, start_date DATETIME NOT NULL, is_valid TINYINT(1) NOT NULL, INDEX IDX_7A6D8BEFA76ED395 (user_id), INDEX IDX_7A6D8BEFE52FAB25 (validate_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE authorization ADD CONSTRAINT FK_7A6D8BEFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE authorization ADD CONSTRAINT FK_7A6D8BEFE52FAB25 FOREIGN KEY (validate_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE authorization');
    }
}
