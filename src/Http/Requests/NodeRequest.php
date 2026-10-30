<?php

namespace LindenCMS\Cms\Http\Requests;


use LindenCMS\Cms\Factories\NodeFactory;
use LindenCMS\Cms\Node;
use Illuminate\Foundation\Http\FormRequest;

class NodeRequest extends FormRequest
{
    protected bool $shouldAutoValidate = false;
    protected Node $node;
    protected NodeFactory $factory;

    public function __construct(NodeFactory $nodeFactory, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->factory = $nodeFactory;
    }

    /**
     * Return new instance on every call
     * @return Node
     */
    public function node(): Node
    {
        return $this->node ?? $this->factory->createFromRequest($this);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Override to prevent automatic validation
     */
    public function validateResolved(): void
    {
        if ($this->shouldAutoValidate) {
            parent::validateResolved();
        }
        // Otherwise, do nothing - validation happens manually later
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->node()->ctx()->valid_rules();
    }

    public function messages()
    {
        return $this->node()->ctx()->valid_messages();
    }

    public function attributes()
    {
        return $this->node()->ctx()->valid_attributes();
    }

    /**
     * Manual validation method
     */
    public function validateNode()
    {
        if (!$this->node()) {
            return [];
        }

        try {
            $this->validate(
                $this->rules(),
                $this->messages(),
                $this->attributes()
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->flattenErrors($e->errors());
        }
    }

    /**
     * Flatten errors to first message per field
     */
    public function flattenErrors(array $errors): array
    {
        $flattened = [];
        foreach ($errors as $field => $messages) {
            $flattened[$field] = is_array($messages) ? $messages[0] : $messages;
        }

        return $flattened;
    }
}
