<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212202532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, feedback_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_DADD4A25D249A887 (feedback_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, plate_id INT DEFAULT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, volume DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, token VARCHAR(255) DEFAULT NULL, shape VARCHAR(255) NOT NULL, thickness INT DEFAULT NULL, width INT DEFAULT NULL, length INT DEFAULT NULL, diameter INT DEFAULT NULL, INDEX IDX_F0FE25274584665A (product_id), INDEX IDX_F0FE2527DF66E98B (plate_id), INDEX IDX_F0FE2527A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configuration (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cutting (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status INT NOT NULL, order_id INT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, billing_address VARCHAR(255) NOT NULL, billing_postal_code INT NOT NULL, billing_city VARCHAR(255) NOT NULL, shipping_address VARCHAR(255) DEFAULT NULL, shipping_postal_code INT DEFAULT NULL, shipping_city VARCHAR(255) DEFAULT NULL, shipping_method INT DEFAULT NULL, shipping_code VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, payment_method INT DEFAULT NULL, shipping_number VARCHAR(255) DEFAULT NULL, order_number VARCHAR(255) DEFAULT NULL, packages INT DEFAULT NULL, height INT DEFAULT NULL, density INT DEFAULT NULL, c_prod VARCHAR(255) DEFAULT NULL, INDEX IDX_FB7C26CDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cutting_item (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, plate_id INT DEFAULT NULL, order_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, volume DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, shape VARCHAR(255) NOT NULL, thickness INT DEFAULT NULL, width INT DEFAULT NULL, length INT DEFAULT NULL, diameter INT DEFAULT NULL, cutted INT NOT NULL, quality VARCHAR(255) NOT NULL, INDEX IDX_7C4120CF4584665A (product_id), INDEX IDX_7C4120CFDF66E98B (plate_id), INDEX IDX_7C4120CF8D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_D2294458A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE foam (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, line INT NOT NULL, comfort INT DEFAULT NULL, density INT DEFAULT NULL, various INT NOT NULL, mattress INT NOT NULL, cake INT NOT NULL, sitting INT NOT NULL, back INT NOT NULL, cuff INT NOT NULL, pillow INT NOT NULL, cap INT NOT NULL, wedging INT NOT NULL, footstool INT NOT NULL, price_cube DOUBLE PRECISION NOT NULL, price_cylinder DOUBLE PRECISION NOT NULL, promo INT NOT NULL, reseller_price DOUBLE PRECISION DEFAULT NULL, reseller_price_ht DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, payement_type VARCHAR(255) DEFAULT NULL, shipment VARCHAR(255) DEFAULT NULL, fee INT DEFAULT NULL, date_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice_article (id INT AUTO_INCREMENT NOT NULL, invoice_id INT DEFAULT NULL, shape VARCHAR(255) DEFAULT NULL, use_case VARCHAR(255) DEFAULT NULL, ref VARCHAR(255) DEFAULT NULL, quantity INT DEFAULT NULL, height INT DEFAULT NULL, length INT DEFAULT NULL, longueur INT DEFAULT NULL, diametre INT DEFAULT NULL, volume DOUBLE PRECISION DEFAULT NULL, price_ht DOUBLE PRECISION DEFAULT NULL, price_ttc DOUBLE PRECISION DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, INDEX IDX_F0E338B52989F1FD (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, ip VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8F3F68C5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status INT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, billing_address VARCHAR(255) NOT NULL, billing_postal_code INT NOT NULL, billing_city VARCHAR(255) NOT NULL, shipping_address VARCHAR(255) DEFAULT NULL, shipping_postal_code INT DEFAULT NULL, shipping_city VARCHAR(255) DEFAULT NULL, shipping_method INT DEFAULT NULL, shipping_code VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, payment_method INT DEFAULT NULL, shipping_number VARCHAR(255) DEFAULT NULL, order_number VARCHAR(255) DEFAULT NULL, packages INT DEFAULT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, plate_id INT DEFAULT NULL, order_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, volume DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, shape VARCHAR(255) NOT NULL, thickness INT DEFAULT NULL, width INT DEFAULT NULL, length INT DEFAULT NULL, diameter INT DEFAULT NULL, cutted INT NOT NULL, INDEX IDX_52EA1F094584665A (product_id), INDEX IDX_52EA1F09DF66E98B (plate_id), INDEX IDX_52EA1F098D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, draft INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plate (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, density INT NOT NULL, thickness INT NOT NULL, width INT NOT NULL, length INT NOT NULL, volume DOUBLE PRECISION NOT NULL, content LONGTEXT NOT NULL, price_ttc DOUBLE PRECISION NOT NULL, price_ht DOUBLE PRECISION NOT NULL, delivery INT NOT NULL, promo INT NOT NULL, best_seller INT NOT NULL, declination VARCHAR(255) DEFAULT NULL, thumbnail VARCHAR(255) NOT NULL, stock INT NOT NULL, draft INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, volume DOUBLE PRECISION NOT NULL, content LONGTEXT NOT NULL, price_ttc DOUBLE PRECISION NOT NULL, price_ht DOUBLE PRECISION NOT NULL, delivery INT NOT NULL, promo INT NOT NULL, best_seller INT NOT NULL, declination VARCHAR(255) DEFAULT NULL, thumbnail VARCHAR(255) NOT NULL, stock INT NOT NULL, draft INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, display INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relay_point_db (id INT AUTO_INCREMENT NOT NULL, one VARCHAR(255) DEFAULT NULL, two VARCHAR(255) DEFAULT NULL, three VARCHAR(255) DEFAULT NULL, four VARCHAR(255) DEFAULT NULL, five VARCHAR(255) DEFAULT NULL, six VARCHAR(255) DEFAULT NULL, seven VARCHAR(255) DEFAULT NULL, eight VARCHAR(255) DEFAULT NULL, nine VARCHAR(255) DEFAULT NULL, ten VARCHAR(255) DEFAULT NULL, eleven VARCHAR(255) DEFAULT NULL, twelve VARCHAR(255) DEFAULT NULL, thirteen VARCHAR(255) DEFAULT NULL, fourteen VARCHAR(255) DEFAULT NULL, fifteen VARCHAR(255) DEFAULT NULL, sixteen VARCHAR(255) DEFAULT NULL, seventeen VARCHAR(255) DEFAULT NULL, eighteen VARCHAR(255) DEFAULT NULL, nineteen VARCHAR(255) DEFAULT NULL, twenty VARCHAR(255) DEFAULT NULL, twentyone VARCHAR(255) DEFAULT NULL, twentytwo VARCHAR(255) DEFAULT NULL, twentythree VARCHAR(255) DEFAULT NULL, twentyfour VARCHAR(255) DEFAULT NULL, twentyfive VARCHAR(255) DEFAULT NULL, twentysix VARCHAR(255) DEFAULT NULL, twentyseven VARCHAR(255) DEFAULT NULL, twentyeight VARCHAR(255) DEFAULT NULL, twentynine VARCHAR(255) DEFAULT NULL, thirty VARCHAR(255) DEFAULT NULL, thirtyone VARCHAR(255) DEFAULT NULL, thirtytwo VARCHAR(255) DEFAULT NULL, thirtythree VARCHAR(255) DEFAULT NULL, thirtyfour VARCHAR(255) DEFAULT NULL, thirtyfive VARCHAR(255) DEFAULT NULL, thirtysix VARCHAR(255) DEFAULT NULL, thirtyseven VARCHAR(255) DEFAULT NULL, thirtyeight VARCHAR(255) DEFAULT NULL, thirtynine VARCHAR(255) DEFAULT NULL, forty VARCHAR(255) DEFAULT NULL, fortyone VARCHAR(255) DEFAULT NULL, fortytwo VARCHAR(255) DEFAULT NULL, fortythree VARCHAR(255) DEFAULT NULL, fortyfour VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reseller_order (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status INT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, billing_address VARCHAR(255) NOT NULL, billing_postal_code INT NOT NULL, billing_city VARCHAR(255) NOT NULL, shipping_address VARCHAR(255) DEFAULT NULL, shipping_postal_code INT DEFAULT NULL, shipping_city VARCHAR(255) DEFAULT NULL, shipping_method INT DEFAULT NULL, shipping_code VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', payment_method INT DEFAULT NULL, shipping_number VARCHAR(255) DEFAULT NULL, order_number VARCHAR(255) DEFAULT NULL, packages INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, INDEX IDX_E7922928A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reseller_order_item (id INT AUTO_INCREMENT NOT NULL, reseller_order_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, quantity INT NOT NULL, thickness DOUBLE PRECISION NOT NULL, width DOUBLE PRECISION NOT NULL, length DOUBLE PRECISION NOT NULL, diameter DOUBLE PRECISION NOT NULL, volume DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, cutted INT NOT NULL, shape VARCHAR(255) DEFAULT NULL, INDEX IDX_811DD8C1A58BF0C (reseller_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code INT NOT NULL, city VARCHAR(255) NOT NULL, shipping_address VARCHAR(255) DEFAULT NULL, shipping_postal_code INT DEFAULT NULL, shipping_city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, role INT NOT NULL, shipping_code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wrap (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, shipping VARCHAR(255) DEFAULT NULL, package_numbers INT DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, package_max_numbers INT DEFAULT NULL, length_max DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wrap_item (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25D249A887 FOREIGN KEY (feedback_id) REFERENCES feedback (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25274584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527DF66E98B FOREIGN KEY (plate_id) REFERENCES plate (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cutting ADD CONSTRAINT FK_FB7C26CDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cutting_item ADD CONSTRAINT FK_7C4120CF4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cutting_item ADD CONSTRAINT FK_7C4120CFDF66E98B FOREIGN KEY (plate_id) REFERENCES plate (id)');
        $this->addSql('ALTER TABLE cutting_item ADD CONSTRAINT FK_7C4120CF8D9F6D38 FOREIGN KEY (order_id) REFERENCES cutting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice_article ADD CONSTRAINT FK_F0E338B52989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09DF66E98B FOREIGN KEY (plate_id) REFERENCES plate (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE reseller_order ADD CONSTRAINT FK_E7922928A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reseller_order_item ADD CONSTRAINT FK_811DD8C1A58BF0C FOREIGN KEY (reseller_order_id) REFERENCES reseller_order (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cutting_item DROP FOREIGN KEY FK_7C4120CF8D9F6D38');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25D249A887');
        $this->addSql('ALTER TABLE invoice_article DROP FOREIGN KEY FK_F0E338B52989F1FD');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098D9F6D38');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527DF66E98B');
        $this->addSql('ALTER TABLE cutting_item DROP FOREIGN KEY FK_7C4120CFDF66E98B');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09DF66E98B');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274584665A');
        $this->addSql('ALTER TABLE cutting_item DROP FOREIGN KEY FK_7C4120CF4584665A');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094584665A');
        $this->addSql('ALTER TABLE reseller_order_item DROP FOREIGN KEY FK_811DD8C1A58BF0C');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527A76ED395');
        $this->addSql('ALTER TABLE cutting DROP FOREIGN KEY FK_FB7C26CDA76ED395');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458A76ED395');
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C5A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE reseller_order DROP FOREIGN KEY FK_E7922928A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('DROP TABLE cutting');
        $this->addSql('DROP TABLE cutting_item');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE foam');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE invoice_article');
        $this->addSql('DROP TABLE log');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE plate');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE relay_point_db');
        $this->addSql('DROP TABLE reseller_order');
        $this->addSql('DROP TABLE reseller_order_item');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE wrap');
        $this->addSql('DROP TABLE wrap_item');
    }
}
