<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Social networks.
 */
final class Version20190301183820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Social networks';
    }

    /**
     * Create social networks columns.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_organization ADD sn_facebook VARCHAR(64) NULL');
        $this->addSql('ALTER TABLE data.te_organization ADD sn_instagram VARCHAR(64) NULL');
        $this->addSql('ALTER TABLE data.te_organization ADD sn_linked_in VARCHAR(64) NULL');
        $this->addSql('ALTER TABLE data.te_organization ADD sn_twitter VARCHAR(64) NULL');
        $this->addSql('ALTER TABLE data.te_organization ADD sn_youtube VARCHAR(64) NULL');
        $this->addSql('COMMENT ON COLUMN data.te_organization.sn_facebook IS \'Facebook account\'');
        $this->addSql('COMMENT ON COLUMN data.te_organization.sn_instagram IS \'Instagram account\'');
        $this->addSql('COMMENT ON COLUMN data.te_organization.sn_linked_in IS \'LinkedIn account\'');
        $this->addSql('COMMENT ON COLUMN data.te_organization.sn_twitter IS \'Twitter account\'');
        $this->addSql('COMMENT ON COLUMN data.te_organization.sn_youtube IS \'Youtube account\'');
        $this->addSql('ALTER TABLE data.te_person ADD sn_facebook VARCHAR(64) NULL');
        $this->addSql('ALTER TABLE data.te_person ADD sn_instagram VARCHAR(64) NULL');
        $this->addSql('ALTER TABLE data.te_person ADD sn_linked_in VARCHAR(64) NULL');
        $this->addSql('ALTER TABLE data.te_person ADD sn_twitter VARCHAR(64) NULL');
        $this->addSql('ALTER TABLE data.te_person ADD sn_youtube VARCHAR(64) NULL');
        $this->addSql('COMMENT ON COLUMN data.te_person.sn_facebook IS \'Facebook account\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.sn_instagram IS \'Instagram account\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.sn_linked_in IS \'LinkedIn account\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.sn_twitter IS \'Twitter account\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.sn_youtube IS \'Youtube account\'');
    }

    /**
     * Drop social network columns.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_organization DROP sn_facebook');
        $this->addSql('ALTER TABLE data.te_organization DROP sn_instagram');
        $this->addSql('ALTER TABLE data.te_organization DROP sn_linked_in');
        $this->addSql('ALTER TABLE data.te_organization DROP sn_twitter');
        $this->addSql('ALTER TABLE data.te_organization DROP sn_youtube');
        $this->addSql('ALTER TABLE data.te_person DROP sn_facebook');
        $this->addSql('ALTER TABLE data.te_person DROP sn_instagram');
        $this->addSql('ALTER TABLE data.te_person DROP sn_linked_in');
        $this->addSql('ALTER TABLE data.te_person DROP sn_twitter');
        $this->addSql('ALTER TABLE data.te_person DROP sn_youtube');
    }
}
