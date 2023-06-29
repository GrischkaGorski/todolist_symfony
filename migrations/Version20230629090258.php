<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230629090258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE todo DROP CONSTRAINT fk_5a0eb6a0a76ed395');
        $this->addSql('DROP INDEX idx_5a0eb6a0a76ed395');
        $this->addSql('ALTER TABLE todo RENAME COLUMN user_id TO person_id');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT FK_5A0EB6A0217BBB47 FOREIGN KEY (person_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A0EB6A0217BBB47 ON todo (person_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE todo DROP CONSTRAINT FK_5A0EB6A0217BBB47');
        $this->addSql('DROP INDEX IDX_5A0EB6A0217BBB47');
        $this->addSql('ALTER TABLE todo RENAME COLUMN person_id TO user_id');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT fk_5a0eb6a0a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5a0eb6a0a76ed395 ON todo (user_id)');
    }
}
