<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Migrations
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Organization table migrations.
 */
final class Version20190226132200 extends AbstractMigration
{
    /**
     * Description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Organization table migrations.';
    }

    /**
     * Create organization table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE data.te_organization_org_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data.te_organization (org_id INT NOT NULL, creator_id INT DEFAULT NULL, org_acronyme TEXT DEFAULT NULL, org_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, org_label VARCHAR(255) NOT NULL, org_legal VARCHAR(255) DEFAULT NULL, org_updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(org_id))');
        $this->addSql('CREATE INDEX ndx_organization_creator ON data.te_organization (creator_id)');
        $this->addSql('CREATE INDEX ndx_organization_label ON data.te_organization (org_legal)');
        $this->addSql('CREATE UNIQUE INDEX uk_organization_label ON data.te_organization (org_label)');
        $this->addSql('COMMENT ON COLUMN data.te_organization.org_id IS \'Identifier\'');
        $this->addSql('COMMENT ON COLUMN data.te_organization.creator_id IS \'Identifiant de l\'\'utilisateur\'');
        $this->addSql('COMMENT ON COLUMN data.te_organization.org_acronyme IS \'Acronym definition\'');
        $this->addSql('COMMENT ON COLUMN data.te_organization.org_created IS \'Creation datetime\'');
        $this->addSql('COMMENT ON COLUMN data.te_organization.org_label IS \'Organization label\'');
        $this->addSql('COMMENT ON COLUMN data.te_organization.org_legal IS \'Legal name organization\'');
        $this->addSql('COMMENT ON COLUMN data.te_organization.org_updated IS \'Update datetime\'');
        $this->addSql('ALTER TABLE data.te_organization ADD CONSTRAINT FK_C3F3D1A461220EA6 FOREIGN KEY (creator_id) REFERENCES data.ts_user (usr_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * Drop organization table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE data.te_organization_org_id_seq CASCADE');
        $this->addSql('DROP TABLE data.te_organization');
    }
}
