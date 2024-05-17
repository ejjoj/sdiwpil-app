<?php

namespace App\Service;

use App\Entity\FrontEndStructureEntityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

abstract class AbstractFrontEndCachableService
{
    protected const CACHE_EXPIRATION_TIME = 600;

    private array $result = [];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AdapterInterface $cache
    ) {
    }

    protected function getCacheExpirationTime(): int
    {
        return self::CACHE_EXPIRATION_TIME;
    }

    abstract protected function getCacheKey(): string;

    abstract protected function getEntityClass(): string;

    public function getResult(): array
    {
        if ($this->isCached()) {
            return $this->getCachedResult();
        }

        $this->handleCachingResults();

        return $this->result;
    }

    private function isCached(): bool
    {
        return $this->cache->getItem(md5($this->getCacheKey()))->isHit();
    }

    private function getCachedResult(): array
    {
        return $this->cache->getItem(md5($this->getCacheKey()))->get();
    }

    private function handleCachingResults(): void
    {
        /** @var FrontEndStructureEntityInterface[] $frontEndStructureEntities */
        $frontEndStructureEntities = $this->entityManager->getRepository($this->getEntityClass())->findAll();
        $result = [];
        foreach ($frontEndStructureEntities as $frontEndStructureEntity) {
            $result[] = $frontEndStructureEntity->toFrontEndArray();
        }
        $cacheItem = $this->cache->getItem(md5($this->getCacheKey()));
        $cacheItem->set($result);
        $cacheItem->expiresAfter($this->getCacheExpirationTime());
        $this->cache->save($cacheItem);
        $this->result = $result;
    }
}
