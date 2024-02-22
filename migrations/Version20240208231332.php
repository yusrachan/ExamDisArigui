<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208231332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(60) NOT NULL, last_name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE artist_type (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_3060D1B6B7970CF8 (artist_id), INDEX IDX_3060D1B6C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE locality (id INT AUTO_INCREMENT NOT NULL, locality VARCHAR(60) NOT NULL, postal_code VARCHAR(6) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(60) NOT NULL, designation VARCHAR(60) NOT NULL, address VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, locality_id INT NOT NULL, INDEX IDX_5E9E89CB88823A92 (locality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE representation (id INT AUTO_INCREMENT NOT NULL, the_date DATETIME NOT NULL, the_show_id INT NOT NULL, the_location_id INT NOT NULL, INDEX IDX_29D5499E3013D282 (the_show_id), INDEX IDX_29D5499ED48E1165 (the_location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, places SMALLINT NOT NULL, user_id INT NOT NULL, representation_id INT NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C8495546CE82F4 (representation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, review LONGTEXT NOT NULL, stars SMALLINT NOT NULL, validated TINYINT(1) NOT NULL, user_id INT DEFAULT NULL, showw_id INT NOT NULL, INDEX IDX_6970EB0FA76ED395 (user_id), INDEX IDX_6970EB0F221C4ECF (showw_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE showw (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(60) NOT NULL, title VARCHAR(255) NOT NULL, bookable TINYINT(1) NOT NULL, description LONGTEXT DEFAULT NULL, poster_url VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, category_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_6B56355D12469DE2 (category_id), INDEX IDX_6B56355D64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE showw_artist_type (showw_id INT NOT NULL, artist_type_id INT NOT NULL, INDEX IDX_FF083682221C4ECF (showw_id), INDEX IDX_FF0836827203D2A4 (artist_type_id), PRIMARY KEY(showw_id, artist_type_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(60) NOT NULL, last_name VARCHAR(60) NOT NULL, email VARCHAR(100) NOT NULL, langue VARCHAR(2) NOT NULL, role_id INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE artist_type ADD CONSTRAINT FK_3060D1B6B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE artist_type ADD CONSTRAINT FK_3060D1B6C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB88823A92 FOREIGN KEY (locality_id) REFERENCES locality (id)');
        $this->addSql('ALTER TABLE representation ADD CONSTRAINT FK_29D5499E3013D282 FOREIGN KEY (the_show_id) REFERENCES showw (id)');
        $this->addSql('ALTER TABLE representation ADD CONSTRAINT FK_29D5499ED48E1165 FOREIGN KEY (the_location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495546CE82F4 FOREIGN KEY (representation_id) REFERENCES representation (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F221C4ECF FOREIGN KEY (showw_id) REFERENCES showw (id)');
        $this->addSql('ALTER TABLE showw ADD CONSTRAINT FK_6B56355D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE showw ADD CONSTRAINT FK_6B56355D64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE showw_artist_type ADD CONSTRAINT FK_FF083682221C4ECF FOREIGN KEY (showw_id) REFERENCES showw (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE showw_artist_type ADD CONSTRAINT FK_FF0836827203D2A4 FOREIGN KEY (artist_type_id) REFERENCES artist_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_type DROP FOREIGN KEY FK_3060D1B6B7970CF8');
        $this->addSql('ALTER TABLE artist_type DROP FOREIGN KEY FK_3060D1B6C54C8C93');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB88823A92');
        $this->addSql('ALTER TABLE representation DROP FOREIGN KEY FK_29D5499E3013D282');
        $this->addSql('ALTER TABLE representation DROP FOREIGN KEY FK_29D5499ED48E1165');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495546CE82F4');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FA76ED395');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F221C4ECF');
        $this->addSql('ALTER TABLE showw DROP FOREIGN KEY FK_6B56355D12469DE2');
        $this->addSql('ALTER TABLE showw DROP FOREIGN KEY FK_6B56355D64D218E');
        $this->addSql('ALTER TABLE showw_artist_type DROP FOREIGN KEY FK_FF083682221C4ECF');
        $this->addSql('ALTER TABLE showw_artist_type DROP FOREIGN KEY FK_FF0836827203D2A4');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artist_type');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE locality');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE representation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE showw');
        $this->addSql('DROP TABLE showw_artist_type');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
