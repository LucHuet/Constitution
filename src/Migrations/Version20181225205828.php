<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181225205828 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE condition_pouvoir_partie DROP FOREIGN KEY FK_B3255A7C3B7A385E');
        $this->addSql('DROP TABLE condition_pouvoir');
        $this->addSql('DROP TABLE condition_pouvoir_partie');
        $this->addSql('ALTER TABLE country_description ADD country_code VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE condition_pouvoir (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_pouvoir_partie (id INT AUTO_INCREMENT NOT NULL, condition_pouvoir_id INT NOT NULL, partie_id INT NOT NULL, pouvoir_partie_id INT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, parametre LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_B3255A7C3B7A385E (condition_pouvoir_id), INDEX IDX_B3255A7CE075F7A4 (partie_id), INDEX IDX_B3255A7C49D3C5A8 (pouvoir_partie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE condition_pouvoir_partie ADD CONSTRAINT FK_B3255A7C3B7A385E FOREIGN KEY (condition_pouvoir_id) REFERENCES condition_pouvoir (id)');
        $this->addSql('ALTER TABLE condition_pouvoir_partie ADD CONSTRAINT FK_B3255A7C49D3C5A8 FOREIGN KEY (pouvoir_partie_id) REFERENCES pouvoir_partie (id)');
        $this->addSql('ALTER TABLE condition_pouvoir_partie ADD CONSTRAINT FK_B3255A7CE075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id)');
        $this->addSql('ALTER TABLE country_description DROP country_code');
    }
}
