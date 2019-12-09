<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191208142310 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE6867958FDDAB70');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795B71D1F67');
        $this->addSql('DROP INDEX IDX_DE6867958FDDAB70 ON package');
        $this->addSql('DROP INDEX IDX_DE686795B71D1F67 ON package');
        $this->addSql('ALTER TABLE package CHANGE owner_id_id owner_id INT NOT NULL, CHANGE courrier_id_id courrier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867957E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867958BF41DC7 FOREIGN KEY (courrier_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DE6867957E3C61F9 ON package (owner_id)');
        $this->addSql('CREATE INDEX IDX_DE6867958BF41DC7 ON package (courrier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE6867957E3C61F9');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE6867958BF41DC7');
        $this->addSql('DROP INDEX IDX_DE6867957E3C61F9 ON package');
        $this->addSql('DROP INDEX IDX_DE6867958BF41DC7 ON package');
        $this->addSql('ALTER TABLE package CHANGE owner_id owner_id_id INT NOT NULL, CHANGE courrier_id courrier_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867958FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795B71D1F67 FOREIGN KEY (courrier_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DE6867958FDDAB70 ON package (owner_id_id)');
        $this->addSql('CREATE INDEX IDX_DE686795B71D1F67 ON package (courrier_id_id)');
    }
}
