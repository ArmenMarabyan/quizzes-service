<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816073127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE quiz_comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE quiz_comment (id INT NOT NULL, quiz_id INT DEFAULT NULL, _user_id INT DEFAULT NULL, text TEXT DEFAULT NULL, photo_filename VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_862EFFCC853CD175 ON quiz_comment (quiz_id)');
        $this->addSql('CREATE INDEX IDX_862EFFCCD32632E8 ON quiz_comment (_user_id)');
        $this->addSql('COMMENT ON COLUMN quiz_comment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN quiz_comment.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE quiz_comment ADD CONSTRAINT FK_862EFFCC853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz_comment ADD CONSTRAINT FK_862EFFCCD32632E8 FOREIGN KEY (_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE quiz_comment_id_seq CASCADE');
        $this->addSql('ALTER TABLE quiz_comment DROP CONSTRAINT FK_862EFFCC853CD175');
        $this->addSql('ALTER TABLE quiz_comment DROP CONSTRAINT FK_862EFFCCD32632E8');
        $this->addSql('DROP TABLE quiz_comment');
    }
}
