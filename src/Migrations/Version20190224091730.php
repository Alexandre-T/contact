<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190224091730 extends AbstractMigration
{
    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Creates user table.';
    }

    /**
     * Alter user table indexes.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.ts_user ADD creator_id INT DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN data.ts_user.creator_id IS \'Identifiant de l\'\'utilisateur\'');
        $this->addSql('ALTER TABLE data.ts_user ADD CONSTRAINT FK_1A98C29961220EA6 FOREIGN KEY (creator_id) REFERENCES data.ts_user (usr_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX ndx_user_creator ON data.ts_user (creator_id)');
        $this->addSql('ALTER INDEX data.uniq_1a98c299d0d90daf RENAME TO uk_user_mail');
        $this->addSql('ALTER INDEX data.uniq_1a98c2993048d892 RENAME TO uk_user_label');
    }

    /**
     * Alter user table indexes.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.ts_user DROP CONSTRAINT FK_1A98C29961220EA6');
        $this->addSql('ALTER TABLE data.ts_user DROP creator_id');
        $this->addSql('ALTER INDEX data.uk_user_label RENAME TO uniq_1a98c2993048d892');
        $this->addSql('ALTER INDEX data.uk_user_mail RENAME TO uniq_1a98c299d0d90daf');
    }
}
