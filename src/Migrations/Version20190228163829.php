<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Migration
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
 * Migration class.
 *
 * Columns renamed.
 */
final class Version20190228163829 extends AbstractMigration
{
    /**
     * Description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Columns renamed';
    }

    /**
     * Columns renamed.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_organization RENAME COLUMN org_created TO ent_created');
        $this->addSql('ALTER TABLE data.te_organization RENAME COLUMN org_updated TO ent_updated');
        $this->addSql('ALTER TABLE data.te_person RENAME COLUMN per_created TO ent_created');
        $this->addSql('ALTER TABLE data.te_person RENAME COLUMN org_updated TO ent_updated');
        $this->addSql('ALTER TABLE data.te_postal ADD creator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE data.te_postal ADD ent_created TIMESTAMP(0) WITHOUT TIME ZONE NULL');
        $this->addSql('ALTER TABLE data.te_postal ADD ent_updated TIMESTAMP(0) WITHOUT TIME ZONE NULL');
        $this->addSql('UPDATE data.te_postal SET ent_created = now(), ent_updated = now()');
        $this->addSql('ALTER TABLE data.te_postal ALTER COLUMN ent_created SET NOT NULL');
        $this->addSql('ALTER TABLE data.te_postal ALTER COLUMN ent_updated SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN data.te_postal.creator_id IS \'Identifiant de l\'\'utilisateur\'');
        $this->addSql('COMMENT ON COLUMN data.te_postal.ent_created IS \'Creation datetime\'');
        $this->addSql('COMMENT ON COLUMN data.te_postal.ent_updated IS \'Update datetime\'');
        $this->addSql('ALTER TABLE data.te_postal ADD CONSTRAINT FK_92244A5061220EA6 FOREIGN KEY (creator_id) REFERENCES data.ts_user (usr_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX ndx_postal_creator ON data.te_postal (creator_id)');
        $this->addSql('ALTER TABLE data.ts_user RENAME COLUMN usr_created TO ent_created');
        $this->addSql('ALTER TABLE data.ts_user RENAME COLUMN usr_updated TO ent_updated');
    }

    /**
     * Columns renamed.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_organization RENAME COLUMN ent_created TO org_created');
        $this->addSql('ALTER TABLE data.te_organization RENAME COLUMN ent_updated TO org_updated');
        $this->addSql('ALTER TABLE data.te_person RENAME COLUMN ent_created TO per_created');
        $this->addSql('ALTER TABLE data.te_person RENAME COLUMN ent_updated TO org_updated');
        $this->addSql('ALTER TABLE data.te_postal DROP CONSTRAINT FK_92244A5061220EA6');
        $this->addSql('ALTER TABLE data.te_postal DROP creator_id');
        $this->addSql('ALTER TABLE data.te_postal DROP ent_created');
        $this->addSql('ALTER TABLE data.te_postal DROP ent_updated');
        $this->addSql('ALTER TABLE data.ts_user RENAME COLUMN ent_created TO usr_created');
        $this->addSql('ALTER TABLE data.ts_user RENAME COLUMN ent_updated TO usr_updated');
    }
}
