<?php

namespace LindenCMS\Cms\Services;

class ConfigResolver
{
    public function getClass(string $code): string
    {
        return config("lindencms.nodes.$code", null);

        // $nodes = config('lindencms.nodes');
        // return $nodes[$code] ?? null;
    }

    public function getCode(string $search)
    {
        $nodes = config('lindencms.nodes');
        foreach ($nodes as $code => $class) {
            if ($class === $search) {
                return $code;
            }
        }

        return null;
    }

    // public function getCodeOrNull(string $search): ?string
    // {
    //     $nodes = config('lindencms.nodes');
    //     foreach ($nodes as $code => $class) {
    //         if ($class === $search) {
    //             return $code;
    //         }
    //     }

    //     return null;
    // }
}