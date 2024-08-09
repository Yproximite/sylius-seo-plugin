<?php

declare(strict_types=1);

namespace Dedi\SyliusSEOPlugin\Api\Persister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Dedi\SyliusSEOPlugin\Entity\SEOContentInterface;
use Dedi\SyliusSEOPlugin\Enum\SEOContentTypeEnum;
use Webmozart\Assert\Assert;

class SEOContentPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(private ContextAwareDataPersisterInterface $decorated)
    {
    }

    public function supports(mixed $data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    public function persist(mixed $data, array $context = []): SEOContentInterface
    {
        Assert::isInstanceOf($data, SEOContentInterface::class);

        if (($context['collection_operation_name'] ?? null) === 'admin_post' ||
            ($context['graphql_operation_name'] ?? null) === 'create') {
            $data->setType(SEOContentTypeEnum::fromSEOContent($data));
        }

        $this->decorated->persist($data, $context);

        return $data;
    }

    public function remove(mixed $data, array $context = []): void
    {
        $this->decorated->remove($data, $context);
    }
}
