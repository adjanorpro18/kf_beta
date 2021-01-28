<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210127144259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP INDEX UNIQ_8D93D649CCFA12B8, ADD INDEX IDX_8D93D649CCFA12B8 (profile_id)');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL, DROP activation_token');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP INDEX IDX_8D93D649CCFA12B8, ADD UNIQUE INDEX UNIQ_8D93D649CCFA12B8 (profile_id)');
        $this->addSql('ALTER TABLE user ADD activation_token VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP is_verified');
    }
}
