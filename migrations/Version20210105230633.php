<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105230633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders ADD delivery_id INT DEFAULT NULL, ADD state INT NOT NULL, ADD delivery_name VARCHAR(255) NOT NULL, ADD delivery_price DOUBLE PRECISION NOT NULL, ADD reference VARCHAR(255) NOT NULL, ADD customer VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE12136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE12136921 ON orders (delivery_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE12136921');
        $this->addSql('DROP INDEX IDX_E52FFDEE12136921 ON orders');
        $this->addSql('ALTER TABLE orders DROP delivery_id, DROP state, DROP delivery_name, DROP delivery_price, DROP reference, DROP customer');
    }
}
