<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200327100249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'migration for drink and drink_type table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE drink (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, contains_alcohol TINYINT(1) NOT NULL, package VARCHAR(255) NOT NULL, price_amount NUMERIC(10, 2) NOT NULL, price_currency VARCHAR(3) DEFAULT \'EUR\' NOT NULL, bottle_deposit_price_amount NUMERIC(10, 2) NOT NULL, bottle_deposit_price_currency VARCHAR(3) DEFAULT \'EUR\' NOT NULL, INDEX IDX_DBE40D1C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drink_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_841484B15E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE drink ADD CONSTRAINT FK_DBE40D1C54C8C93 FOREIGN KEY (type_id) REFERENCES drink_type (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE drink DROP FOREIGN KEY FK_DBE40D1C54C8C93');
        $this->addSql('DROP TABLE drink');
        $this->addSql('DROP TABLE drink_type');
    }
}
