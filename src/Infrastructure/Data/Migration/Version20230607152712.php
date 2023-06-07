<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607152712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration with the creation of the schema';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE `bookings` (
              `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
              `reference` CHAR(6) NOT NULL,
              `check_in` DATE NOT NULL,
              `check_out` DATE NOT NULL,
              `people` TINYINT(1) NOT NULL,
              `modified_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
              `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `reference_UNIQUE` (`reference` ASC) VISIBLE);
        ");

        $this->addSql("
            CREATE TABLE `insurances` (
              `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
              `booking_id` INT UNSIGNED NOT NULL,
              `policy` CHAR(9) NOT NULL,
              `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `policy_UNIQUE` (`policy` ASC) VISIBLE,
              INDEX `fk_insurances_1_idx` (`booking_id` ASC) VISIBLE,
              CONSTRAINT `fk_insurances_1`
                FOREIGN KEY (`booking_id`)
                REFERENCES `bookings`.`bookings` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);
        ");

        $this->addSql("
            CREATE TABLE `actions` (
              `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
              `booking_id` INT UNSIGNED NOT NULL,
              `action` TINYINT(1) NOT NULL,
              `check_in` DATE NOT NULL,
              `check_out` DATE NOT NULL,
              `people` TINYINT(1) NOT NULL,
              `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              INDEX `fk_actions_1_idx` (`booking_id` ASC) VISIBLE,
              CONSTRAINT `fk_actions_1`
                FOREIGN KEY (`booking_id`)
                REFERENCES `bookings`.`bookings` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE `actions`;");
        $this->addSql("DROP TABLE `insurances`;");
        $this->addSql("DROP TABLE `bookings`;");
    }
}
