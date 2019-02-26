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
 * Postal address table migrations.
 */
final class Version20190226090322 extends AbstractMigration
{
    /**
     * Description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Postal address table migrations';
    }

    /**
     * Create postal address table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE data.te_postal_pad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data.te_postal (pad_id INT NOT NULL, country_id INT DEFAULT NULL, pad_locality VARCHAR(255) DEFAULT NULL, pad_box VARCHAR(32) DEFAULT NULL, pad_code VARCHAR(5) DEFAULT NULL, pad_street VARCHAR(255) DEFAULT NULL, PRIMARY KEY(pad_id))');
        $this->addSql('CREATE INDEX ndx_postal_country ON data.te_postal (country_id)');
        $this->addSql('CREATE INDEX ndx_postal_code ON data.te_postal (pad_code)');
        $this->addSql('CREATE INDEX ndx_postal_locality ON data.te_postal (pad_locality)');
        $this->addSql('COMMENT ON COLUMN data.te_postal.pad_id IS \'Postal address identifier\'');
        $this->addSql('COMMENT ON COLUMN data.te_postal.country_id IS \'Country internal identifier\'');
        $this->addSql('COMMENT ON COLUMN data.te_postal.pad_locality IS \'Locality\'');
        $this->addSql('COMMENT ON COLUMN data.te_postal.pad_box IS \'Post office box number\'');
        $this->addSql('COMMENT ON COLUMN data.te_postal.pad_code IS \'Postal code\'');
        $this->addSql('COMMENT ON COLUMN data.te_postal.pad_street IS \'Complete treet address\'');
        $this->addSql('ALTER TABLE data.te_postal ADD CONSTRAINT FK_92244A50F92F3E70 FOREIGN KEY (country_id) REFERENCES data.tr_country (cou_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * Drop postal address code.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE data.te_postal_pad_id_seq CASCADE');
        $this->addSql('DROP TABLE data.te_postal');
    }
}
