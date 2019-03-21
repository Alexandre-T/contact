<?php
/**
 * This file is part of the contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @thematic Tests
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
 * Thematic.
 *
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190320160934 extends AbstractMigration
{
    /**
     * Description.
     *
     * @return string
     */
    public function getDescription() : string
    {
        return 'Thematic';
    }

    /**
     * Add thematic table.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE data.tr_thematic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data.tj_person_thematic (person_id INT NOT NULL, thematic_id INT NOT NULL, PRIMARY KEY(person_id, thematic_id))');
        $this->addSql('CREATE INDEX IDX_18B78DF9217BBB47 ON data.tj_person_thematic (person_id)');
        $this->addSql('CREATE INDEX IDX_18B78DF92395FCED ON data.tj_person_thematic (thematic_id)');
        $this->addSql('CREATE TABLE data.tr_thematic (id INT NOT NULL, the_code VARCHAR(5) NOT NULL, the_label VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uk_thematic_code ON data.tr_thematic (the_code)');
        $this->addSql('CREATE UNIQUE INDEX uk_thematic_label ON data.tr_thematic (the_label)');
        $this->addSql('ALTER TABLE data.tj_person_thematic ADD CONSTRAINT FK_18B78DF9217BBB47 FOREIGN KEY (person_id) REFERENCES data.te_person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE data.tj_person_thematic ADD CONSTRAINT FK_18B78DF92395FCED FOREIGN KEY (thematic_id) REFERENCES data.tr_thematic (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * Drop table thematic.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.tj_person_thematic DROP CONSTRAINT FK_18B78DF92395FCED');
        $this->addSql('DROP SEQUENCE data.tr_thematic_id_seq CASCADE');
        $this->addSql('DROP TABLE data.tj_person_thematic');
        $this->addSql('DROP TABLE data.tr_thematic');
    }
}
