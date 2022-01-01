<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210801154233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE holiday_request ADD validby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE holiday_request ADD CONSTRAINT FK_94ACA91350F2ED9 FOREIGN KEY (validby_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_94ACA91350F2ED9 ON holiday_request (validby_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE holiday_request DROP FOREIGN KEY FK_94ACA91350F2ED9');
        $this->addSql('DROP INDEX IDX_94ACA91350F2ED9 ON holiday_request');
        $this->addSql('ALTER TABLE holiday_request DROP validby_id');
    }
}
