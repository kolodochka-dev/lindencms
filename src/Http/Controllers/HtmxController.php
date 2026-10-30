<?php

namespace LindenCMS\Cms\Http\Controllers;

use LindenCMS\Cms\Http\Requests\NodeRequest;

class HtmxController extends Controller
{
    public function __invoke(NodeRequest $request, string $method)
    {
        return $this->{$method}($request);
    }

    // TODO: Services Injection to the Contexts
    private function context(NodeRequest $request)
    {
        $path = $request->query('path', '');
        $context = $request->query('context');
        $data = $request->query('data', []);

        // node
        $rootNode = $request->node();

        // path
        if (!$path) {
            $node = $rootNode;
        } elseif (!$node = $rootNode->path($path, true)) {
            abort(404, "Node '$path' not found!");
        }

        if (!in_array($context, $node->allowedHttpContexts())) {
            abort(403);
        }

        // context <- data, Request
        return $node->ctx()->$context($data, $request);
    }

    // private function addCollectionItem(NodeRequest $request)
    // {
    //     if (!$request->has(['path', 'code'])) {
    //         abort(400, 'Missing required parameters (path, code) must be provided');
    //     }

    //     $node = $request->node();

    //     /** @var NodeCollection */
    //     $collection = $node->path($request->query('path'), true);

    //     return $collection->makeItem()->context($request->input('context', 'html.form'));
    // }

    // public function upload(NodeRequest $request)
    // {
    //     $required = ['path', 'code'];
    //     if (!$request->has($required)) {
    //         abort(400, 'Missing required parameters (' . implode(',', $required) . ') must be provided');
    //     }

    //     $rootNode = $request->node();

    //     /** @var FileUploads */
    //     $fileUploads = $rootNode->path($request->query('path'), true);
    //     try {
    //         $request->validate(rules: [
    //             'files.*' => $fileUploads->_validation()->rules,
    //         ], attributes: [
    //             'files.*' => 'file :ordinal-position',
    //         ]);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return new FileMessage(id: $request->messagesId, error: $request->flattenErrors($e->errors()));
    //     }

    //     $files = $this->fileManager->uploadFromRequest($request, $fileUploads->_file());

    //     return implode([
    //         new FileUploadedList(
    //             $request->uploadedListId,
    //             implode(array_map(fn($file) => $fileUploads->makeItem()->context('html.uploaded', [
    //                 'file' => $file,
    //                 ...$request->input('data', []),
    //             ]), $files))
    //         ),
    //         new FileMessage(id: $request->messagesId, success: ['File uploaded successfully']),
    //     ]);
    // }
}
