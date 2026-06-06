<?php

namespace LindenCMS\Cms\Factories;

use LindenCMS\Core\Node;
use LindenCMS\Cms\Services\ConfigResolver;
use Illuminate\Http\Request;

class NodeRequestFactory
{
    public function __construct(
        private ConfigResolver $configResolver
    ) {}

    public function createFromRequest(Request $request): Node
    {
        if (empty($request->code)) {
            throw new \Exception('Node config code is required');
        }

        $data = $this->sanitizeData($request->post());

        $class = $this->configResolver->getClass($request->code);
        /** @var Node */
        $node = $class::make();
        
        $node->fill($data[$node->toSnakeCase()] ?? []);

        // TODO: do
        // if (empty($entity->id->get()) && !empty($request->id)) {
        //     $entity->id->set((int) $request->id);
        // }

        return $node;
    }

    /**
     * When sending nested data via hx-vals and using $request->all(), 
     * the nested values are still in JSON format.
     */
    private function sanitizeData(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = json_decode($value, true);
            }
        }

        return $data;
    }
}
