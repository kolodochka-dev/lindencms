<?php

namespace LindenCMS\Cms\Http\Requests;

use LindenCMS\Cms\Factories\NodeRequestFactory;
use LindenCMS\Cms\Nodes\AppNode;
use Illuminate\Foundation\Http\FormRequest;

class NodeCollectionRequest extends FormRequest
{
    protected string $code;
    protected Filters $filters;
    protected NodeRequestFactory $nodeFactory;

    public function __construct(NodeRequestFactory $nodeFactory, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->nodeFactory = $nodeFactory;

        return parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function node(): ?AppNode
    {
        return $this->nodeFactory->createFromRequest($this);
    }
    
    /**
     * Determine if the user is authorized
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->code = $this->route('code');
        $this->filters = new Filters(
            filter: $this->getFilter(),
            perPage: $this->getPerPage(),
            sort: $this->getSort(),
            page: $this->getPage(),
            code: $this->getCode(),
            urlQuery: $this->getUrlQuery(),
        );
        $this->filters->save();
    }

    public function getFilters(): Filters
    {
        return $this->filters;
    }
    
    /**
     * Get filter values from request or session
     */
    public function getFilter(): array
    {
        if ($this->query('resetFilter', false)) {
            return [];
        }
        
        return $this->query('filter', session("filter.{$this->code}", []));
    }
    
    /**
     * Get per page value from request or session
     */
    public function getPerPage(): int
    {
        return (int) $this->query('perPage', session("perPage.{$this->code}", 15));
    }
    
    /**
     * Get sort values from request or session
     */
    public function getSort(): array
    {
        if ($this->query('resetSort', false)) {
            return [];
        }
        
        return $this->query('sort', session("sort.{$this->code}", []));
    }
    
    /**
     * Get page number
     */
    public function getPage(): int
    {
        return (int) $this->query('page', 1);
    }
    
    /**
     * Get URL query for Paginator
     */
    public function getUrlQuery(): array
    {
        return $this->except(['filter', 'resetFilter', 'perPage', 'sort', 'resetSort', 'page']);
    }
    
    /**
     * Get code from route
     */
    public function getCode(): string
    {
        return $this->code;
    }
    
    /**
     * Get the validation rules
     */
    public function rules(): array
    {
        return [
            'perPage' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
        ];
    }
}