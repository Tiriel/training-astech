<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241106162633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, project_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, accessible BOOLEAN NOT NULL, prerequisites CLOB DEFAULT NULL, start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_3BAE0AA7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7166D1F9C ON event (project_id)');
        $this->addSql('CREATE TABLE organization (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, presentation CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TABLE organization_event (organization_id INTEGER NOT NULL, event_id INTEGER NOT NULL, PRIMARY KEY(organization_id, event_id), CONSTRAINT FK_B529EC6032C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B529EC6071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B529EC6032C8A3DE ON organization_event (organization_id)');
        $this->addSql('CREATE INDEX IDX_B529EC6071F7E88B ON organization_event (event_id)');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, summary CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TABLE project_organization (project_id INTEGER NOT NULL, organization_id INTEGER NOT NULL, PRIMARY KEY(project_id, organization_id), CONSTRAINT FK_EB49871F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EB49871F32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EB49871F166D1F9C ON project_organization (project_id)');
        $this->addSql('CREATE INDEX IDX_EB49871F32C8A3DE ON project_organization (organization_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
        $this->addSql('CREATE TABLE volunteer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, event_id INTEGER NOT NULL, project_id INTEGER DEFAULT NULL, for_user_id INTEGER NOT NULL, start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_5140DEDB71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5140DEDB166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5140DEDB9B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5140DEDB71F7E88B ON volunteer (event_id)');
        $this->addSql('CREATE INDEX IDX_5140DEDB166D1F9C ON volunteer (project_id)');
        $this->addSql('CREATE INDEX IDX_5140DEDB9B5BB4B8 ON volunteer (for_user_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE organization_event');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_organization');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE volunteer');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
