<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Country table removed.
 */
final class Version20190301163700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Country table removed';
    }

    /**
     * Drop country table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_person DROP CONSTRAINT fk_15ea6fb35debd613');
        $this->addSql('ALTER TABLE data.te_postal DROP CONSTRAINT fk_92244a50f92f3e70');
        $this->addSql('DROP SEQUENCE data.tr_country_cou_id_seq CASCADE');
        $this->addSql('DROP TABLE data.tr_country');
        $this->addSql('ALTER TABLE data.te_person ADD per_nationality VARCHAR(2) DEFAULT NULL');
        $this->addSql("UPDATE data.te_person SET per_nationality='FR'");
        $this->addSql('ALTER TABLE data.te_person DROP birthcountry_id');
        $this->addSql('COMMENT ON COLUMN data.te_person.per_nationality IS \'Nationality alpha2 code\'');
        $this->addSql('CREATE INDEX ndx_person_birthCountry ON data.te_person (per_nationality)');
        $this->addSql('ALTER TABLE data.te_postal ADD pad_country VARCHAR(2) NULL');
        $this->addSql("UPDATE data.te_postal SET pad_country='FR'");
        $this->addSql('ALTER TABLE data.te_postal ALTER pad_country SET NOT NULL');
        $this->addSql('ALTER TABLE data.te_postal DROP country_id');
        $this->addSql('COMMENT ON COLUMN data.te_postal.pad_country IS \'Postal address country alpha2 code\'');
        $this->addSql('CREATE INDEX ndx_postal_country ON data.te_postal (pad_country)');
    }

    /**
     * Restore country table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE data.tr_country_cou_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data.tr_country (cou_id INT NOT NULL, cou_alpha2 VARCHAR(2) NOT NULL, cou_alpha3 VARCHAR(3) NOT NULL, cou_english VARCHAR(255) NOT NULL, cou_french VARCHAR(255) NOT NULL, cou_numeric SMALLINT NOT NULL, PRIMARY KEY(cou_id))');
        $this->addSql('CREATE INDEX ndx_country_english ON data.tr_country (cou_english)');
        $this->addSql('CREATE INDEX ndx_country_french ON data.tr_country (cou_french)');
        $this->addSql('CREATE UNIQUE INDEX uk_country_alpha2 ON data.tr_country (cou_alpha2)');
        $this->addSql('CREATE UNIQUE INDEX uk_country_numeric ON data.tr_country (cou_numeric)');
        $this->addSql('CREATE UNIQUE INDEX uk_country_alpha3 ON data.tr_country (cou_alpha3)');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_id IS \'Country internal identifier\'');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_alpha2 IS \'Alpha2 code\'');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_alpha3 IS \'Alpha3 code\'');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_english IS \'English name\'');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_french IS \'French name\'');
        $this->addSql('COMMENT ON COLUMN data.tr_country.cou_numeric IS \'Numeric code\'');
        $this->addSql('ALTER TABLE data.te_person ADD birthcountry_id INT NULL');
        $this->addSql('ALTER TABLE data.te_person DROP per_nationality');
        $this->addSql('COMMENT ON COLUMN data.te_person.birthcountry_id IS \'Country internal identifier\'');
        $this->addSql('ALTER TABLE data.te_person ADD CONSTRAINT fk_15ea6fb35debd613 FOREIGN KEY (birthcountry_id) REFERENCES data.tr_country (cou_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX ndx_person_birthcountry ON data.te_person (birthcountry_id)');
        $this->addSql('ALTER TABLE data.te_postal ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE data.te_postal DROP pad_country');
        $this->addSql('COMMENT ON COLUMN data.te_postal.country_id IS \'Country internal identifier\'');
        $this->addSql('ALTER TABLE data.te_postal ADD CONSTRAINT fk_92244a50f92f3e70 FOREIGN KEY (country_id) REFERENCES data.tr_country (cou_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX ndx_postal_country ON data.te_postal (country_id)');
    }
}
