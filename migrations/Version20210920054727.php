<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920054727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, balance INT NOT NULL, INDEX IDX_7C68921F9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet_operation (id INT AUTO_INCREMENT NOT NULL, wallet_id INT NOT NULL, type VARCHAR(20) NOT NULL, details LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_4E1DB6FC712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE wallet_operation ADD CONSTRAINT FK_4E1DB6FC712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921F9B6B5FBA');
        $this->addSql('ALTER TABLE wallet_operation DROP FOREIGN KEY FK_4E1DB6FC712520F3');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('DROP TABLE wallet_operation');
    }
}
