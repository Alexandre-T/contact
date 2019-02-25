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
 * Country table migrations.
 */
final class Version20190225151315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Country table migrations';
    }

    /**
     * Create country table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE data.tr_country_cou_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data.tr_country (cou_id INT NOT NULL, cou_alpha2 VARCHAR(2) NOT NULL, cou_alpha3 VARCHAR(3) NOT NULL, cou_english VARCHAR(255) NOT NULL, cou_french VARCHAR(255) NOT NULL, cou_numeric SMALLINT NOT NULL, PRIMARY KEY(cou_id))');
        $this->addSql('CREATE INDEX ndx_country_english ON data.tr_country (cou_english)');
        $this->addSql('CREATE INDEX ndx_country_french ON data.tr_country (cou_french)');
        $this->addSql('CREATE UNIQUE INDEX uk_country_alpha2 ON data.tr_country (cou_alpha2)');
        $this->addSql('CREATE UNIQUE INDEX uk_country_alpha3 ON data.tr_country (cou_alpha3)');
        $this->addSql('CREATE UNIQUE INDEX uk_country_numeric ON data.tr_country (cou_numeric)');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_id IS \'Country internal identifier\'');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_alpha2 IS \'Alpha2 code\'');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_alpha3 IS \'Alpha3 code\'');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_english IS \'English name\'');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_french IS \'French name\'');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_numeric IS \'Numeric code\'');
    }

    /**
     * Drop country table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE data.tr_country_cou_id_seq CASCADE');
        $this->addSql('DROP TABLE data.tr_country');
    }
}
