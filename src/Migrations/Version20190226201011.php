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
 * Connection between organization and postal address tables.
 */
final class Version20190226201011 extends AbstractMigration
{
    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription() : string
    {
        return 'Connection between organization and postal address tables.';
    }

    /**
     * Create connection between organization and postal address tables.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_organization ADD address_id INT DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN data.te_organization.address_id IS \'Postal address identifier\'');
        $this->addSql('ALTER TABLE data.te_organization ADD CONSTRAINT FK_C3F3D1A4F5B7AF75 FOREIGN KEY (address_id) REFERENCES data.te_postal (pad_id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uk_organization_address ON data.te_organization (address_id)');
    }

    /**
     * Drop connection between organization and postal address.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_organization DROP CONSTRAINT FK_C3F3D1A4F5B7AF75');
        $this->addSql('ALTER TABLE data.te_organization DROP address_id');
    }
}
