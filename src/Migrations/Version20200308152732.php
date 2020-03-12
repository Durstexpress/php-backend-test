<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200308152732 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $drinkTypes = [
            ['name' => 'Vodka'],
            ['name' => 'Rum'],
            ['name' => 'Whiskey'],
            ['name' => 'Liqueur'],
            ['name' => 'Grain'],
            ['name' => 'Tequila'],
            ['name' => 'Spirit'],
        ];

        foreach ($drinkTypes as $drinkType) {
            $this->addSql('INSERT INTO drink_type (name) VALUES (:name)', $drinkType);
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
