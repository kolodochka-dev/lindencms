<?php

namespace LindenCMS\Cms\Http\Controllers;

use LindenCMS\Cms\Contracts\NodeRepositoryContract;
use LindenCMS\Cms\Factories\NodeRepositoryFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use LindenCMS\Cms\Http\Controllers\Controller;
use LindenCMS\Cms\Http\Requests\NodeCollectionRequest;
use LindenCMS\Cms\Http\Requests\NodeRequest;

class NodeController extends Controller
{
    private NodeRepositoryContract $repository;

    public function __construct(NodeRepositoryFactory $repositoryFactory, Request $request)
    {
        if (!empty($request->code)) {
            $this->repository = $repositoryFactory->create($request->code);
            // throw new \Exception('Node code parameter is required!');
        }
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

    public function index(NodeCollectionRequest $request, string $code)
    {
        $node = $request->node();
        if ($node->_view()?->singlePage) {
            return redirect(
                ($id = $node->context('db.query')->orderBy('id')->first()?->id)
                ? route('nodes.edit', [$code, $id])
                : route('nodes.create', $code)
            );
        }

        $filters = $request->getFilters();
        [$node, $paginator] = $this->repository->all(
            page: $filters->page,
            perPage: $filters->perPage,
            urlPath: route('nodes.index', [$code]),
            urlQuery: $filters->urlQuery,
            filter: $filters->filter,
            sort: $filters->sort,
        );

        if ($request->header('HX-Request')) {
            return $node->context('html.index', [
                'paginator' => $paginator,
            ]);
        }

        return view('cms::layouts.base-index', [
            'node' => $node,
            'paginator' => $paginator,
        ]);
    }

    public function create(Request $request)
    {
        $node = $this->repository->empty();

        if ($request->header('HX-Request')) {
            return $node->context('html.edit');
        }

        return view('cms::layouts.base-edit', [
            'node' => $node,
        ]);
    }

    public function edit(Request $request, string $code, int $id)
    {
        if (!$node = $this->repository->get($id)) {
            abort(404);
        }

        if ($request->header('HX-Request')) {
            return $node->context('html.edit');
        }

        return view('cms::layouts.base-edit', [
            'node' => $node,
        ]);
    }

    public function store(NodeRequest $request)
    {
        $node = $request->node();
        if (!$errors = $request->validateNode()) {
            $node = $this->repository->save($node);

            return Response::htmxReplaceUrl(route('nodes.edit', [
                'code' => $node->context('config.code'),
                'id' => $node->id->get(),
            ]), $node->context('html.edit'));
        }

        return $node->context('html.edit', [
            'errors' => $errors,
        ]);
    }

    public function update(NodeRequest $request)
    {
        $node = $request->node();
        if ($errors = $request->validateNode()) {
            return response($node->context('html.edit', [
                'errors' => $errors,
                // can't make because HTMX dont handle error reponses
            ])/* , 422 */);
        }

        $node = $this->repository->save($node);

        return $node->context('html.edit');
    }

    public function show(NodeRequest $request, string $code, int $id)
    {
        if (!$node = $this->repository->get($id)) {
            abort(404);
        }

        if ($request->header('HX-Request')) {
            return $node->context('html.show');
        }

        return view('cms::layouts.base-show', [
            'node' => $node,
        ]);
    }

    public function delete(string $code, int $id)
    {
        $this->repository->delete($id);

        return Response::htmxRedirect(route('nodes.index', $code));
    }

    public function deletes(Request $request, string $code)
    {
        foreach ($request->input('ids', []) as $id) {
            $this->repository->delete($id);
        }

        return Response::htmxRedirect(route('nodes.index', $code));
    }

    public function copy(string $code, int $id)
    {
        $this->repository->copy($id);

        return Response::htmxRedirect(route('nodes.index', $code));
    }

    public function copies(Request $request, string $code)
    {
        foreach ($request->input('ids', []) as $id) {
            $this->repository->copy($id);
        }

        return Response::htmxRedirect(route('nodes.index', $code));
    }
}
