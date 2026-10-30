<?php

namespace LindenCMS\Cms\Http\Requests;

class FilterableNodeRequest extends NodeRequest
{
    protected string $code;
    protected Filters $filters;

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // $this->code = $this->route('code');
        // $this->filters = new Filters(
        //     filter: $this->getFilter(),
        //     perPage: $this->getPerPage(),
        //     sort: $this->getSort(),
        //     page: $this->getPage(),
        //     code: $this->getCode(),
        //     urlQuery: $this->getUrlQuery(),
        // );
        // $this->filters->save();
    }

    public function getFilters(): Filters
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
