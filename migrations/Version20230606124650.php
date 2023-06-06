<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606124650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE todo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tag_todo (tag_id INT NOT NULL, todo_id INT NOT NULL, PRIMARY KEY(tag_id, todo_id))');
        $this->addSql('CREATE INDEX IDX_B4010916BAD26311 ON tag_todo (tag_id)');
        $this->addSql('CREATE INDEX IDX_B4010916EA1EBC33 ON tag_todo (todo_id)');
        $this->addSql('CREATE TABLE todo (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, done BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE tag_todo ADD CONSTRAINT FK_B4010916BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_todo ADD CONSTRAINT FK_B4010916EA1EBC33 FOREIGN KEY (todo_id) REFERENCES todo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE todo_id_seq CASCADE');
        $this->addSql('ALTER TABLE tag_todo DROP CONSTRAINT FK_B4010916BAD26311');
        $this->addSql('ALTER TABLE tag_todo DROP CONSTRAINT FK_B4010916EA1EBC33');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_todo');
        $this->addSql('DROP TABLE todo');
    }
}
