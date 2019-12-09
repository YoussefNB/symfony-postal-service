<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191208142206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE package ADD owner_id_id INT NOT NULL, ADD courrier_id_id INT DEFAULT NULL, DROP owner_id, DROP courrier_id');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867958FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795B71D1F67 FOREIGN KEY (courrier_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DE6867958FDDAB70 ON package (owner_id_id)');
        $this->addSql('CREATE INDEX IDX_DE686795B71D1F67 ON package (courrier_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE6867958FDDAB70');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795B71D1F67');
        $this->addSql('DROP INDEX IDX_DE6867958FDDAB70 ON package');
        $this->addSql('DROP INDEX IDX_DE686795B71D1F67 ON package');
        $this->addSql('ALTER TABLE package ADD courrier_id INT NOT NULL, DROP courrier_id_id, CHANGE owner_id_id owner_id INT NOT NULL');
    }
}
