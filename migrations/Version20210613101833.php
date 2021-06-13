<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210613101833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature ADD rendez_vous_date_time DATETIME DEFAULT NULL, ADD rendez_vous_comment VARCHAR(255) DEFAULT NULL, ADD rendez_vous_enligne TINYINT(1) DEFAULT NULL, ADD rendez_vous_place_link VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP rendez_vous_date_time, DROP rendez_vous_comment, DROP rendez_vous_enligne, DROP rendez_vous_place_link');
    }
}
