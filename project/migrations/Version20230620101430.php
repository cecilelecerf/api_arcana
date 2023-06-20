<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620101430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD picture_id_id INT NOT NULL, DROP picture');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7FF9E1919 FOREIGN KEY (picture_id_id) REFERENCES picture_post (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7FF9E1919 ON event (picture_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7FF9E1919');
        $this->addSql('DROP INDEX IDX_3BAE0AA7FF9E1919 ON event');
        $this->addSql('ALTER TABLE event ADD picture LONGTEXT NOT NULL, DROP picture_id_id');
    }
}
