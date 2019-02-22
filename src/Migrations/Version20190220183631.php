<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190220183631 extends AbstractMigration
{
    /**
     * Description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'This script create user table.';
    }

    /**
     * Migration up.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA data');
        $this->addSql('CREATE SEQUENCE data.ts_user_usr_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data.ts_user (usr_id INT NOT NULL, usr_label VARCHAR(32) NOT NULL, usr_mail VARCHAR(255) NOT NULL, password VARCHAR(64) DEFAULT NULL, usr_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, usr_updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, roles JSON DEFAULT NULL, PRIMARY KEY(usr_id))');
        $this->addSql('CREATE UNIQUE INDEX uk_user_label ON data.ts_user (usr_label)');
        $this->addSql('CREATE UNIQUE INDEX uk_user_mail ON data.ts_user (usr_mail)');
        $this->addSql('COMMENT ON COLUMN data.ts_user.usr_id IS \'Identifiant de l\'\'utilisateur\'');
        $this->addSql('COMMENT ON COLUMN data.ts_user.password IS \'Mot de passe crypté\'');
        $this->addSql('COMMENT ON COLUMN data.ts_user.usr_created IS \'Creation datetime\'');
        $this->addSql('COMMENT ON COLUMN data.ts_user.usr_updated IS \'Update datetime\'');
        $this->addSql('COMMENT ON COLUMN data.ts_user.roles IS \'Roles de l\'\'utilisateur(DC2Type:json_array)\'');
    }

    /**
     * Migration down.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE data.ts_user_usr_id_seq CASCADE');
        $this->addSql('DROP TABLE data.ts_user');
        $this->addSql('DROP SCHEMA data');
    }
}
