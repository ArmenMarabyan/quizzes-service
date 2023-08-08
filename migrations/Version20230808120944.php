<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230808120944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE quiz_result_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE quiz_result (id INT NOT NULL, _user_id INT DEFAULT NULL, quiz_id INT DEFAULT NULL, answers_count SMALLINT NOT NULL, correct_answers_count SMALLINT NOT NULL, score INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FE2E314AD32632E8 ON quiz_result (_user_id)');
        $this->addSql('CREATE INDEX IDX_FE2E314A853CD175 ON quiz_result (quiz_id)');
        $this->addSql('COMMENT ON COLUMN quiz_result.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN quiz_result.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE quiz_result ADD CONSTRAINT FK_FE2E314AD32632E8 FOREIGN KEY (_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz_result ADD CONSTRAINT FK_FE2E314A853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE quiz ALTER status DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE quiz_result_id_seq CASCADE');
        $this->addSql('ALTER TABLE quiz_result DROP CONSTRAINT FK_FE2E314AD32632E8');
        $this->addSql('ALTER TABLE quiz_result DROP CONSTRAINT FK_FE2E314A853CD175');
        $this->addSql('DROP TABLE quiz_result');
        $this->addSql('ALTER TABLE quiz ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE quiz ALTER status SET DEFAULT 0');
    }
}
