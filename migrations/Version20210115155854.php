<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210115155854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity_publics (activity_id INT NOT NULL, publics_id INT NOT NULL, INDEX IDX_7861611C81C06096 (activity_id), INDEX IDX_7861611C60CCAA7C (publics_id), PRIMARY KEY(activity_id, publics_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_category (activity_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_A646A9CF81C06096 (activity_id), INDEX IDX_A646A9CF12469DE2 (category_id), PRIMARY KEY(activity_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_publics ADD CONSTRAINT FK_7861611C81C06096 FOREIGN KEY (activity_id) REFERENCES activity1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_publics ADD CONSTRAINT FK_7861611C60CCAA7C FOREIGN KEY (publics_id) REFERENCES publics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_category ADD CONSTRAINT FK_A646A9CF81C06096 FOREIGN KEY (activity_id) REFERENCES activity1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_category ADD CONSTRAINT FK_A646A9CF12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity1 ADD user_id INT NOT NULL, ADD type_activity_id INT NOT NULL, ADD state_id INT NOT NULL');
        $this->addSql('ALTER TABLE activity1 ADD CONSTRAINT FK_AC74095AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE activity1 ADD CONSTRAINT FK_AC74095ACAD9B707 FOREIGN KEY (type_activity_id) REFERENCES type_activity (id)');
        $this->addSql('ALTER TABLE activity1 ADD CONSTRAINT FK_AC74095A5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_AC74095AA76ED395 ON activity1 (user_id)');
        $this->addSql('CREATE INDEX IDX_AC74095ACAD9B707 ON activity1 (type_activity_id)');
        $this->addSql('CREATE INDEX IDX_AC74095A5D83CC1 ON activity1 (state_id)');
        $this->addSql('ALTER TABLE category ADD pictures_id INT DEFAULT NULL, ADD type_activities_id INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1BC415685 FOREIGN KEY (pictures_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C15AA00257 FOREIGN KEY (type_activities_id) REFERENCES type_activity (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1BC415685 ON category (pictures_id)');
        $this->addSql('CREATE INDEX IDX_64C19C15AA00257 ON category (type_activities_id)');
        $this->addSql('ALTER TABLE comment ADD user_id INT NOT NULL, ADD comment_id INT DEFAULT NULL, ADD activity_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C81C06096 FOREIGN KEY (activity_id) REFERENCES activity1 (id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526CF8697D13 ON comment (comment_id)');
        $this->addSql('CREATE INDEX IDX_9474526C81C06096 ON comment (activity_id)');
        $this->addSql('ALTER TABLE picture ADD activity_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8981C06096 FOREIGN KEY (activity_id) REFERENCES activity1 (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F8981C06096 ON picture (activity_id)');
        $this->addSql('ALTER TABLE profile ADD icon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F54B9D732 FOREIGN KEY (icon_id) REFERENCES icon (id)');
        $this->addSql('CREATE INDEX IDX_8157AA0F54B9D732 ON profile (icon_id)');
        $this->addSql('ALTER TABLE user ADD profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CCFA12B8 ON user (profile_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE activity_publics');
        $this->addSql('DROP TABLE activity_category');
        $this->addSql('ALTER TABLE activity1 DROP FOREIGN KEY FK_AC74095AA76ED395');
        $this->addSql('ALTER TABLE activity1 DROP FOREIGN KEY FK_AC74095ACAD9B707');
        $this->addSql('ALTER TABLE activity1 DROP FOREIGN KEY FK_AC74095A5D83CC1');
        $this->addSql('DROP INDEX IDX_AC74095AA76ED395 ON activity1');
        $this->addSql('DROP INDEX IDX_AC74095ACAD9B707 ON activity1');
        $this->addSql('DROP INDEX IDX_AC74095A5D83CC1 ON activity1');
        $this->addSql('ALTER TABLE activity1 DROP user_id, DROP type_activity_id, DROP state_id');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1BC415685');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C15AA00257');
        $this->addSql('DROP INDEX IDX_64C19C1BC415685 ON category');
        $this->addSql('DROP INDEX IDX_64C19C15AA00257 ON category');
        $this->addSql('ALTER TABLE category DROP pictures_id, DROP type_activities_id');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF8697D13');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C81C06096');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395 ON comment');
        $this->addSql('DROP INDEX IDX_9474526CF8697D13 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C81C06096 ON comment');
        $this->addSql('ALTER TABLE comment DROP user_id, DROP comment_id, DROP activity_id');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8981C06096');
        $this->addSql('DROP INDEX IDX_16DB4F8981C06096 ON picture');
        $this->addSql('ALTER TABLE picture DROP activity_id');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F54B9D732');
        $this->addSql('DROP INDEX IDX_8157AA0F54B9D732 ON profile');
        $this->addSql('ALTER TABLE profile DROP icon_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('DROP INDEX UNIQ_8D93D649CCFA12B8 ON user');
        $this->addSql('ALTER TABLE user DROP profile_id');
    }
}
