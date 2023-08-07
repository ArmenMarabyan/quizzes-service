<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230807123005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz ADD _user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz ADD status SMALLINT DEFAULT 0');
        $this->addSql('ALTER TABLE quiz ALTER updated_at SET DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92D32632E8 FOREIGN KEY (_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A412FA92D32632E8 ON quiz (_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE quiz DROP CONSTRAINT FK_A412FA92D32632E8');
        $this->addSql('DROP INDEX IDX_A412FA92D32632E8');
        $this->addSql('ALTER TABLE quiz DROP _user_id');
        $this->addSql('ALTER TABLE quiz DROP status');
        $this->addSql('ALTER TABLE quiz ALTER updated_at DROP NOT NULL');
    }
}
