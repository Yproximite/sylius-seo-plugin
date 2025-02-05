<?php

declare(strict_types=1);

namespace Dedi\SyliusSEOPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250114142339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            INSERT INTO dedi_sylius_seo_content_robots (seo_content_id, locale_code, is_not_indexable)
            SELECT translatable_id, locale, seo_not_indexable FROM dedi_sylius_seo_content_translation
        ');
        $this->addSql('
            UPDATE dedi_sylius_seo_content SET `type` = "product"
            WHERE id IN (
                SELECT referenceableContent_id FROM sylius_product WHERE referenceableContent_id IS NOT NULL
            )
        ');
        $this->addSql('
            UPDATE dedi_sylius_seo_content SET `type` = "taxon"
            WHERE id IN (
                SELECT referenceableContent_id FROM sylius_taxon WHERE referenceableContent_id IS NOT NULL
            )
        ');
        $this->addSql('
            UPDATE dedi_sylius_seo_content SET `type` = "channel"
            WHERE id IN (
                SELECT referenceableContent_id FROM sylius_channel WHERE referenceableContent_id IS NOT NULL
            )
        ');
    }

    public function down(Schema $schema): void
    {
    }
}
