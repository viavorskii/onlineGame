<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170628090756 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('INSERT into monster (name, life, hit_min, hit_max) values ("Godzilla", 100, 30, 35)');
        $this->addSql('INSERT into monster (name, life, hit_min, hit_max) values ("Bear", 100, 15, 30)');
        $this->addSql('INSERT into monster (name, life, hit_min, hit_max) values ("Fox", 100, 10, 15)');
        $this->addSql('INSERT into monster (name, life, hit_min, hit_max) values ("Mouse", 100, 5, 13)');
        $this->addSql('INSERT into  role (name, life, hit_min, hit_max) values ("Monster", 100, 10, 15)');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
