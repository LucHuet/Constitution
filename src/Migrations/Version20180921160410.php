<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180921160410 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE acteur_partie (id INT AUTO_INCREMENT NOT NULL, partie_id INT NOT NULL, type_acteur_id INT NOT NULL, nom VARCHAR(255) NOT NULL, nombre_individus INT DEFAULT NULL, INDEX IDX_CF6D2253E075F7A4 (partie_id), INDEX IDX_CF6D22536EA9165A (type_acteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_pouvoir (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_pouvoir_partie (id INT AUTO_INCREMENT NOT NULL, condition_pouvoir_id INT NOT NULL, nom VARCHAR(255) NOT NULL, parametre LONGTEXT DEFAULT NULL, INDEX IDX_B3255A7C3B7A385E (condition_pouvoir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designation_partie (id INT AUTO_INCREMENT NOT NULL, designation_id INT NOT NULL, acteur_designe_id INT NOT NULL, acteur_designant_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_24553869FAC7D83F (designation_id), INDEX IDX_245538697995E169 (acteur_designe_id), INDEX IDX_2455386951964AD6 (acteur_designant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pouvoir_partie (id INT AUTO_INCREMENT NOT NULL, partie_id INT NOT NULL, pouvoir_id INT NOT NULL, pouvoir_destinataire_id INT DEFAULT NULL, condition_pouvoir_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_E7B47292E075F7A4 (partie_id), INDEX IDX_E7B47292C8A705F8 (pouvoir_id), UNIQUE INDEX UNIQ_E7B47292B67244C5 (pouvoir_destinataire_id), UNIQUE INDEX UNIQ_E7B472923B7A385E (condition_pouvoir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pouvoir_partie_acteur_partie (pouvoir_partie_id INT NOT NULL, acteur_partie_id INT NOT NULL, INDEX IDX_C7DC682E49D3C5A8 (pouvoir_partie_id), INDEX IDX_C7DC682E9C0A0ED3 (acteur_partie_id), PRIMARY KEY(pouvoir_partie_id, acteur_partie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE droit_devoir (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE droit_devoir_partie (droit_devoir_id INT NOT NULL, partie_id INT NOT NULL, INDEX IDX_F036C13AD86B629 (droit_devoir_id), INDEX IDX_F036C13E075F7A4 (partie_id), PRIMARY KEY(droit_devoir_id, partie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valeur_principe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valeur_principe_partie (valeur_principe_id INT NOT NULL, partie_id INT NOT NULL, INDEX IDX_1760720A81AD7E66 (valeur_principe_id), INDEX IDX_1760720AE075F7A4 (partie_id), PRIMARY KEY(valeur_principe_id, partie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C2502824F85E0677 (username), UNIQUE INDEX UNIQ_C2502824E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acteur (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partie (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_59B1F3DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pouvoir (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, importance INT NOT NULL, is_controle TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designation (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acteur_partie ADD CONSTRAINT FK_CF6D2253E075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id)');
        $this->addSql('ALTER TABLE acteur_partie ADD CONSTRAINT FK_CF6D22536EA9165A FOREIGN KEY (type_acteur_id) REFERENCES acteur (id)');
        $this->addSql('ALTER TABLE condition_pouvoir_partie ADD CONSTRAINT FK_B3255A7C3B7A385E FOREIGN KEY (condition_pouvoir_id) REFERENCES condition_pouvoir (id)');
        $this->addSql('ALTER TABLE designation_partie ADD CONSTRAINT FK_24553869FAC7D83F FOREIGN KEY (designation_id) REFERENCES designation (id)');
        $this->addSql('ALTER TABLE designation_partie ADD CONSTRAINT FK_245538697995E169 FOREIGN KEY (acteur_designe_id) REFERENCES acteur_partie (id)');
        $this->addSql('ALTER TABLE designation_partie ADD CONSTRAINT FK_2455386951964AD6 FOREIGN KEY (acteur_designant_id) REFERENCES acteur_partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B47292E075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B47292C8A705F8 FOREIGN KEY (pouvoir_id) REFERENCES pouvoir (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B47292B67244C5 FOREIGN KEY (pouvoir_destinataire_id) REFERENCES pouvoir_partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B472923B7A385E FOREIGN KEY (condition_pouvoir_id) REFERENCES condition_pouvoir_partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie_acteur_partie ADD CONSTRAINT FK_C7DC682E49D3C5A8 FOREIGN KEY (pouvoir_partie_id) REFERENCES pouvoir_partie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pouvoir_partie_acteur_partie ADD CONSTRAINT FK_C7DC682E9C0A0ED3 FOREIGN KEY (acteur_partie_id) REFERENCES acteur_partie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE droit_devoir_partie ADD CONSTRAINT FK_F036C13AD86B629 FOREIGN KEY (droit_devoir_id) REFERENCES droit_devoir (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE droit_devoir_partie ADD CONSTRAINT FK_F036C13E075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE valeur_principe_partie ADD CONSTRAINT FK_1760720A81AD7E66 FOREIGN KEY (valeur_principe_id) REFERENCES valeur_principe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE valeur_principe_partie ADD CONSTRAINT FK_1760720AE075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3DA76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE designation_partie DROP FOREIGN KEY FK_245538697995E169');
        $this->addSql('ALTER TABLE designation_partie DROP FOREIGN KEY FK_2455386951964AD6');
        $this->addSql('ALTER TABLE pouvoir_partie_acteur_partie DROP FOREIGN KEY FK_C7DC682E9C0A0ED3');
        $this->addSql('ALTER TABLE condition_pouvoir_partie DROP FOREIGN KEY FK_B3255A7C3B7A385E');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B472923B7A385E');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B47292B67244C5');
        $this->addSql('ALTER TABLE pouvoir_partie_acteur_partie DROP FOREIGN KEY FK_C7DC682E49D3C5A8');
        $this->addSql('ALTER TABLE droit_devoir_partie DROP FOREIGN KEY FK_F036C13AD86B629');
        $this->addSql('ALTER TABLE valeur_principe_partie DROP FOREIGN KEY FK_1760720A81AD7E66');
        $this->addSql('ALTER TABLE partie DROP FOREIGN KEY FK_59B1F3DA76ED395');
        $this->addSql('ALTER TABLE acteur_partie DROP FOREIGN KEY FK_CF6D22536EA9165A');
        $this->addSql('ALTER TABLE acteur_partie DROP FOREIGN KEY FK_CF6D2253E075F7A4');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B47292E075F7A4');
        $this->addSql('ALTER TABLE droit_devoir_partie DROP FOREIGN KEY FK_F036C13E075F7A4');
        $this->addSql('ALTER TABLE valeur_principe_partie DROP FOREIGN KEY FK_1760720AE075F7A4');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B47292C8A705F8');
        $this->addSql('ALTER TABLE designation_partie DROP FOREIGN KEY FK_24553869FAC7D83F');
        $this->addSql('DROP TABLE acteur_partie');
        $this->addSql('DROP TABLE condition_pouvoir');
        $this->addSql('DROP TABLE condition_pouvoir_partie');
        $this->addSql('DROP TABLE designation_partie');
        $this->addSql('DROP TABLE pouvoir_partie');
        $this->addSql('DROP TABLE pouvoir_partie_acteur_partie');
        $this->addSql('DROP TABLE droit_devoir');
        $this->addSql('DROP TABLE droit_devoir_partie');
        $this->addSql('DROP TABLE valeur_principe');
        $this->addSql('DROP TABLE valeur_principe_partie');
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE acteur');
        $this->addSql('DROP TABLE partie');
        $this->addSql('DROP TABLE pouvoir');
        $this->addSql('DROP TABLE designation');
    }
}