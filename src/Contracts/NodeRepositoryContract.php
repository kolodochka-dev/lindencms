<?php

namespace LindenCMS\Cms\Contracts;

use LindenCMS\Cms\Nodes\AppNode;

interface NodeRepositoryContract
{
    public function empty(): AppNode;
    public function get(int $id): ?AppNode;
    public function all(int $page, int $perPage, string $urlPath, array $urlQuery, ?array $filter = [], ?array $sort = []): array;
    // public function index(array $filters = []): IndexCollection;
    // public function one(array $filters = []): Entity;
    public function delete(int $id);
    public function copy(int $id);
    public function save(AppNode $node): AppNode;
    // public function update(Entity $entity): Entity;
    // public function patch(Field $entity): Field;
    // public function copy(Entity $entity): Entity;
}
