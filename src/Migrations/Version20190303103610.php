<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Category entity.
 */
final class Version20190303103610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Category entity';
    }

    /**
     * Create category table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE data.tr_categorie_cat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data.tr_categorie (cat_id INT NOT NULL, cat_label VARCHAR(32) NOT NULL, PRIMARY KEY(cat_id))');
        $this->addSql('CREATE UNIQUE INDEX ul_category_label ON data.tr_categorie (cat_label)');
        $this->addSql('COMMENT ON COLUMN data.tr_categorie.cat_id IS \'Category identifier\'');
        $this->addSql('ALTER TABLE data.te_person ADD category_id INT NOT NULL');
        $this->addSql('COMMENT ON COLUMN data.te_person.category_id IS \'Category identifier\'');
        $this->addSql('ALTER TABLE data.te_person ADD CONSTRAINT FK_15EA6FB312469DE2 FOREIGN KEY (category_id) REFERENCES data.tr_categorie (cat_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX ndx_person_category ON data.te_person (category_id)');
    }

    /**
     * Drop category table.
     *
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE data.te_person DROP CONSTRAINT FK_15EA6FB312469DE2');
        $this->addSql('DROP SEQUENCE data.tr_categorie_cat_id_seq CASCADE');
        $this->addSql('DROP TABLE data.tr_categorie');
        $this->addSql('ALTER TABLE data.te_person DROP category_id');
    }
}
