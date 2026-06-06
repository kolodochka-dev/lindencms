<?php

namespace LindenCMS\Cms\Services;

class ConfigResolver
{
    public function getClass(string $code): string
    {
        $nodes = config('lindencms.nodes');
        if (!array_key_exists($code, $nodes)) {
            throw new \RuntimeException("Node with a code '{$code}' isn't registered");
        }

        return $nodes[$code];
    }

    public function getCode(string $search)
    {
        $nodes = config('lindencms.nodes');
        foreach ($nodes as $code => $class) {
            if ($class === $search) {
                return $code;
            }
        }

        throw new \RuntimeException("Node class '{$search}' isn't registered");
    }

    public function getCodeOrNull(string $search): ?string
    {
        $nodes = config('lindencms.nodes');
        foreach ($nodes as $code => $class) {
            if ($class === $search) {
                return $code;
            }
        }

        return null;
    }
}