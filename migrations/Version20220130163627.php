<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130163627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ads ADD category_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE ads ADD CONSTRAINT FK_7EC9F6209777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_7EC9F6209777D11E ON ads (category_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ads DROP FOREIGN KEY FK_7EC9F6209777D11E');
        $this->addSql('DROP INDEX IDX_7EC9F6209777D11E ON ads');
        $this->addSql('ALTER TABLE ads DROP category_id_id');
    }
}
