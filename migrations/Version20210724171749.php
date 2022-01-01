<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210724171749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE validated_holiday_by (id INT AUTO_INCREMENT NOT NULL, holiday_id_id INT DEFAULT NULL, INDEX IDX_C7F1B2A456FEA190 (holiday_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE validated_holiday_by ADD CONSTRAINT FK_C7F1B2A456FEA190 FOREIGN KEY (holiday_id_id) REFERENCES holiday_request (id)');
        $this->addSql('ALTER TABLE user ADD validated_holiday_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A4793EFB FOREIGN KEY (validated_holiday_by_id) REFERENCES validated_holiday_by (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A4793EFB ON user (validated_holiday_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A4793EFB');
        $this->addSql('DROP TABLE validated_holiday_by');
        $this->addSql('DROP INDEX IDX_8D93D649A4793EFB ON user');
        $this->addSql('ALTER TABLE user DROP validated_holiday_by_id');
    }
}
