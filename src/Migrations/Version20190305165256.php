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
 * Service entity.
 */
final class Version20190305165256 extends AbstractMigration
{
    /**
     * Migration description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Service entity';
    }

    /**
     * Create service.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE data.te_service_ser_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data.te_service (ser_id INT NOT NULL, organization_id INT NOT NULL, creator_id INT DEFAULT NULL, ser_name VARCHAR(64) NOT NULL, ent_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ent_updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(ser_id))');
        $this->addSql('CREATE INDEX ndx_service_creator ON data.te_service (creator_id)');
        $this->addSql('CREATE INDEX ndx_service_organization ON data.te_service (organization_id)');
        $this->addSql('CREATE UNIQUE INDEX uk_service_name ON data.te_service (ser_name)');
        $this->addSql('COMMENT ON COLUMN data.te_service.ser_id IS \'Service identifier\'');
        $this->addSql('COMMENT ON COLUMN data.te_service.organization_id IS \'Identifier\'');
        $this->addSql('COMMENT ON COLUMN data.te_service.creator_id IS \'Identifiant de l\'\'utilisateur\'');
        $this->addSql('COMMENT ON COLUMN data.te_service.ser_name IS \'Service name\'');
        $this->addSql('COMMENT ON COLUMN data.te_service.ent_created IS \'Creation datetime\'');
        $this->addSql('COMMENT ON COLUMN data.te_service.ent_updated IS \'Update datetime\'');
        $this->addSql('ALTER TABLE data.te_service ADD CONSTRAINT FK_AB29A5332C8A3DE FOREIGN KEY (organization_id) REFERENCES data.te_organization (org_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE data.te_service ADD CONSTRAINT FK_AB29A5361220EA6 FOREIGN KEY (creator_id) REFERENCES data.ts_user (usr_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE data.te_person ADD service_id INT NULL');
        $this->addSql('COMMENT ON COLUMN data.te_person.service_id IS \'Service identifier\'');
        $this->addSql('ALTER TABLE data.te_person ADD CONSTRAINT FK_15EA6FB3ED5CA9E6 FOREIGN KEY (service_id) REFERENCES data.te_service (ser_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX ndx_person_service ON data.te_person (service_id)');
    }

    /**
     * Drop service.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_person DROP CONSTRAINT FK_15EA6FB3ED5CA9E6');
        $this->addSql('DROP SEQUENCE data.te_service_ser_id_seq CASCADE');
        $this->addSql('DROP TABLE data.te_service');
        $this->addSql('ALTER TABLE data.te_person DROP service_id');
    }
}
