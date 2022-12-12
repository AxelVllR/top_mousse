<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825135117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE foam (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, comfort INT NOT NULL, density INT NOT NULL, various INT NOT NULL, mattress INT NOT NULL, cake INT NOT NULL, sitting INT NOT NULL, back INT NOT NULL, cuff INT NOT NULL, pillow INT NOT NULL, cap INT NOT NULL, wedging INT NOT NULL, footstool INT NOT NULL, price_per_cube DOUBLE PRECISION NOT NULL, cylinder_price DOUBLE PRECISION NOT NULL, promo INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE foam');
    }
}
