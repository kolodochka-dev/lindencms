<?php

namespace LindenCMS\Cms\Http\Controllers;

use LindenCMS\Cms\Http\Requests\NodeRequest;
use LindenCMS\Cms\Http\Requests\FilterableNodeRequest;
use LindenCMS\Cms\IndexCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NodeController extends Controller
{
    // public function index(NodeCollectionRequest $request, string $code)
    // {
    //     $node = $request->node();
    //     if ($node->_view()?->singlePage) {
    //         return redirect(
    //             ($id = $node->context('db.query')->orderBy('id')->first()?->id)
    //             ? route('nodes.edit', [$code, $id])
    //             : route('nodes.create', $code)
    //         );
    //     }

    //     $filters = $request->getFilters();
    //     [$node, $paginator] = $this->repository->all(
    //         page: $filters->page,
    //         perPage: $filters->perPage,
    //         urlPath: route('nodes.index', [$code]),
    //         urlQuery: $filters->urlQuery,
    //         filter: $filters->filter,
    //         sort: $filters->sort,
    //     );

    //     if ($request->header('HX-Request')) {
    //         return $node->context('html.index', [
    //             'paginator' => $paginator,
    //         ]);
    //     }

    //     return view('cms::layouts.base-index', [
    //         'node' => $node,
    //         'paginator' => $paginator,
    //     ]);
    // }


    public function index(FilterableNodeRequest $request, string $code)
    {
        $node = $request->node();
        if ($node->_view()?->singlePage) {
            $redirect = ($id = $node->db_query()->orderBy('id')->first()?->id)
                ? route('nodes.edit', [$code, $id])
                : route('nodes.create', $code);

            return redirect($redirect);
        }

        $filters = $request->getFilters();
        $nodes = IndexCollection::make();
        $nodes->setType($node);

        ['paginator' => $paginator] = $nodes->ctx()->db_refresh([
            "page" => $filters->page,
            "perPage" => $filters->perPage,
            "path" => route('nodes.index', [$code]),
            "query" => $filters->urlQuery,
            // "filter" => $filters->filter,
            // "sort" => $filters->sort,
        ]);

        if ($request->header('HX-Request')) {
            return $nodes->ctx()->html_index($paginator);
        }

        return view('cms::layouts.base-index', [
            'nodes' => $nodes,
            'paginator' => $paginator,
        ]);
    }

    public function dashboard()
    {
        $nodes = [];
        foreach (config('lindencms.dashboard') as $nodeClass) {
            $nodes[] = $nodeClass::make();
        }

        return view('cms::dashboard', [
            'nodes' => $nodes,
        ]);
    }

    public function create(NodeRequest $request)
    {
        $node = $request->node();
        if ($request->header('HX-Request')) {
            return $node->ctx()->html_edit();
        }

        return view('cms::layouts.base-edit', [
            'node' => $node,
        ]);
    }

    public function store(NodeRequest $request)
    {
        $node = $request->node();
        if ($errors = $request->validateNode()) {
            return $node->ctx()->html_edit(errors: $errors);
        }

        $node->ctx()->db_save($request->post($node->toSnakeCase(), []));

        return Response::htmxReplaceUrl(route('nodes.edit', [
            'code' => $node->code(),
            'id' => $node->id->get(),
        ]), $node->ctx()->html_edit());
    }

    public function edit(NodeRequest $request, string $code, int $id)
    {
        $node = $request->node();
        if (!$node->ctx()->db_refresh($id)) {
            abort(404);
        }

        if ($request->header('HX-Request')) {
            return $node->ctx()->html_edit();
        }

        return view('cms::layouts.base-edit', [
            'node' => $node,
        ]);
    }

    public function update(NodeRequest $request)
    {
        $node = $request->node();
        if ($errors = $request->validateNode()) {
            return $node->ctx()->html_edit(errors: $errors);
        }

        $node->ctx()->db_save($request->post($node->toSnakeCase(), []));

        return $node->ctx()->html_edit();
    }

    public function delete(NodeRequest $request, string $code, int $id)
    {
        $node = $request->node();
        $node->ctx()->db_delete($id);

        return Response::htmxRedirect(route('nodes.index', $code));
    }

    // public function deletes(Request $request, string $code)
    // {
    //     foreach ($request->input('ids', []) as $id) {
    //         $this->repository->delete($id);
    //     }

    //     return Response::htmxRedirect(route('nodes.index', $code));
    // }

    // public function copy(string $code, int $id)
    // {
    //     $this->repository->copy($id);

    //     return Response::htmxRedirect(route('nodes.index', $code));
    // }

    // public function copies(Request $request, string $code)
    // {
    //     foreach ($request->input('ids', []) as $id) {
    //         $this->repository->copy($id);
    //     }

    //     return Response::htmxRedirect(route('nodes.index', $code));
    // }
}
