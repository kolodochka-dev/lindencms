<?php

namespace LindenCMS\Cms\Factories;

use LindenCMS\Cms\Contracts\NodeRepositoryContract;
use LindenCMS\Cms\Repositories\NodeRepository;
use LindenCMS\Cms\Services\ConfigResolver;

class NodeRepositoryFactory
{
    public function __construct(
        private ConfigResolver $configResolver
    ) {}

    // move to the app provider
    private array $customRepositories = [
        // 'news' => NewsEntityRepository::class,
        // 'users' => UserEntityRepository::class,
    ];

    public function create(string $code): NodeRepositoryContract
    {
        $nodeClass = $this->configResolver->getClass($code);
        if (isset($this->customRepositories[$code])) {
            return $this->createCustomRepository($code);
        }

        return new NodeRepository($nodeClass);
    }

    private function createCustomRepository(string $entityCode): NodeRepositoryContract
    {
        $repositoryClass = $this->customRepositories[$entityCode];

        return app($repositoryClass);
    }
}
