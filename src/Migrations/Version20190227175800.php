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
 * Person table creation.
 */
final class Version20190227175800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Person table';
    }

    /**
     * Create person table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE data.te_person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data.te_person (id INT NOT NULL, address_id INT DEFAULT NULL, school_id INT DEFAULT NULL, creator_id INT DEFAULT NULL, organization_id INT DEFAULT NULL, per_birthName VARCHAR(32) DEFAULT NULL, per_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, per_email VARCHAR(255) DEFAULT NULL, per_familyName VARCHAR(32) NOT NULL, per_gender SMALLINT DEFAULT NULL, per_givenName VARCHAR(32) DEFAULT NULL, per_jobTitle VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, org_updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, birthCountry_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX ndx_person_alumni ON data.te_person (school_id)');
        $this->addSql('CREATE INDEX ndx_person_birthCountry ON data.te_person (birthCountry_id)');
        $this->addSql('CREATE INDEX ndx_person_birthName ON data.te_person (per_birthName, per_givenName)');
        $this->addSql('CREATE INDEX ndx_person_creator ON data.te_person (creator_id)');
        $this->addSql('CREATE INDEX ndx_person_familyName ON data.te_person (per_familyName, per_givenName)');
        $this->addSql('CREATE INDEX ndx_person_member ON data.te_person (organization_id)');
        $this->addSql('CREATE UNIQUE INDEX uk_person_address ON data.te_person (address_id)');
        $this->addSql('COMMENT ON COLUMN data.te_person.address_id IS \'Postal address identifier\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.school_id IS \'Identifier\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.creator_id IS \'Identifiant de l\'\'utilisateur\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.organization_id IS \'Identifier\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.per_birthName IS \'Birth name\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.per_created IS \'Creation datetime\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.per_email IS \'Email\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.per_familyName IS \'Family and usage name\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.per_gender IS \'Gender 1 for male, 2 for female, 3 for others.\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.per_givenName IS \'Given name\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.per_jobTitle IS \'Job title\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.org_updated IS \'Update datetime\'');
        $this->addSql('COMMENT ON COLUMN data.te_person.birthCountry_id IS \'Country internal identifier\'');
        $this->addSql('ALTER TABLE data.te_person ADD CONSTRAINT FK_15EA6FB3F5B7AF75 FOREIGN KEY (address_id) REFERENCES data.te_postal (pad_id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE data.te_person ADD CONSTRAINT FK_15EA6FB3C32A47EE FOREIGN KEY (school_id) REFERENCES data.te_organization (org_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE data.te_person ADD CONSTRAINT FK_15EA6FB361220EA6 FOREIGN KEY (creator_id) REFERENCES data.ts_user (usr_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE data.te_person ADD CONSTRAINT FK_15EA6FB332C8A3DE FOREIGN KEY (organization_id) REFERENCES data.te_organization (org_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE data.te_person ADD CONSTRAINT FK_15EA6FB35DEBD613 FOREIGN KEY (birthCountry_id) REFERENCES data.tr_country (cou_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * Drop person table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE data.te_person_id_seq CASCADE');
        $this->addSql('DROP TABLE data.te_person');
    }
}
