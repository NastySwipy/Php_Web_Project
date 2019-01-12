<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190111154642 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, date_added DATETIME NOT NULL, product_name VARCHAR(255) NOT NULL, product_type VARCHAR(255) NOT NULL, make VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, product_color VARCHAR(255) NOT NULL, product_weight INT NOT NULL, price NUMERIC(10, 2) NOT NULL, quantity INT NOT NULL, isNew TINYINT(1) NOT NULL, productLocationContinent VARCHAR(255) NOT NULL, productLocationCountry VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, imageUrl VARCHAR(255) NOT NULL, INDEX IDX_B3BA5A5AF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE products');
    }
}
