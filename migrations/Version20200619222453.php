<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200619222453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_import ADD import_file_id INT NOT NULL, ADD error TINYINT(1) DEFAULT NULL, ADD error_message VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE detail_import ADD CONSTRAINT FK_8F84D78680DBD080 FOREIGN KEY (import_file_id) REFERENCES import_files (id)');
        $this->addSql('CREATE INDEX IDX_8F84D78680DBD080 ON detail_import (import_file_id)');
        $this->addSql('ALTER TABLE import_files ADD error TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_import DROP FOREIGN KEY FK_8F84D78680DBD080');
        $this->addSql('DROP INDEX IDX_8F84D78680DBD080 ON detail_import');
        $this->addSql('ALTER TABLE detail_import DROP import_file_id, DROP error, DROP error_message');
        $this->addSql('ALTER TABLE import_files DROP error');
    }
}
