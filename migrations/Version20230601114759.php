<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601114759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag_todo (tag_id INT NOT NULL, todo_id INT NOT NULL, PRIMARY KEY(tag_id, todo_id))');
        $this->addSql('CREATE INDEX IDX_B4010916BAD26311 ON tag_todo (tag_id)');
        $this->addSql('CREATE INDEX IDX_B4010916EA1EBC33 ON tag_todo (todo_id)');
        $this->addSql('ALTER TABLE tag_todo ADD CONSTRAINT FK_B4010916BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_todo ADD CONSTRAINT FK_B4010916EA1EBC33 FOREIGN KEY (todo_id) REFERENCES todo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE todos_tags DROP CONSTRAINT fk_cfa0fde3ea1ebc33');
        $this->addSql('ALTER TABLE todos_tags DROP CONSTRAINT fk_cfa0fde3bad26311');
        $this->addSql('DROP TABLE todos_tags');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE todos_tags (todo_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(todo_id, tag_id))');
        $this->addSql('CREATE INDEX idx_cfa0fde3bad26311 ON todos_tags (tag_id)');
        $this->addSql('CREATE INDEX idx_cfa0fde3ea1ebc33 ON todos_tags (todo_id)');
        $this->addSql('ALTER TABLE todos_tags ADD CONSTRAINT fk_cfa0fde3ea1ebc33 FOREIGN KEY (todo_id) REFERENCES todo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE todos_tags ADD CONSTRAINT fk_cfa0fde3bad26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_todo DROP CONSTRAINT FK_B4010916BAD26311');
        $this->addSql('ALTER TABLE tag_todo DROP CONSTRAINT FK_B4010916EA1EBC33');
        $this->addSql('DROP TABLE tag_todo');
    }
}
