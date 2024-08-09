<?php

declare(strict_types=1);

namespace Dedi\SyliusSEOPlugin\Enum;

use Dedi\SyliusSEOPlugin\Entity\SEOContentInterface;
use Dedi\SyliusSEOPlugin\Entity\SEOContentTranslationInterface;

class SEOContentTypeEnum
{
    private const PRODUCT = 'product';

    private const TAXON = 'taxon';

    private const CHANNEL = 'channel';

    private const URI = 'uri';

    private function __construct()
    {
    }

    public static function fromSEOContent(SEOContentInterface $SEOContent): ?string
    {
        /** @var SEOContentTranslationInterface $translation */
        foreach ($SEOContent->getTranslations() as $translation) {
            if ($translation->getUri() !== null) {
                return self::URI;
            }
        }

        if ($SEOContent->getProduct() !== null) {
            return self::PRODUCT;
        }
        if ($SEOContent->getTaxon() !== null) {
            return self::TAXON;
        }
        if ($SEOContent->getChannel() !== null) {
            return self::CHANNEL;
        }

        return null;
    }
}
