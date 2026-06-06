<?php

namespace LindenCMS\Cms\Http\Requests;

use LindenCMS\Cms\Contracts\NodeRequestConract;
use LindenCMS\Core\Node;
use Illuminate\Foundation\Http\FormRequest;
use LindenCMS\Cms\Factories\NodeRequestFactory;
use LindenCMS\Cms\Nodes\AppNode;

class NodeRequest extends FormRequest implements NodeRequestConract
{
    protected bool $shouldAutoValidate = false;
    protected NodeRequestFactory $nodeFactory;
    protected ?AppNode $node = null;

    public function __construct(NodeRequestFactory $nodeFactory, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->nodeFactory = $nodeFactory;

        return parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function node(): ?Node
    {
        return $this->node ?? $this->nodeFactory->createFromRequest($this);
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
        return $this->node()->context('valid.rules');
    }

    public function messages()
    {
        return $this->node()->context('valid.messages');
    }

    public function attributes()
    {
        return $this->node()->context('valid.attributes');
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
