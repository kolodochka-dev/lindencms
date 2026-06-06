<?php

namespace LindenCMS\Cms\Http\Controllers;

use LindenCMS\Cms\Factories\NodeRequestFactory;
use LindenCMS\Cms\Http\Controllers\Controller;
use LindenCMS\Core\NodeCollection;
use LindenCMS\Cms\Http\Requests\NodeRequest;
use LindenCMS\Cms\Nodes\FileUploads;
use LindenCMS\Cms\Services\FileManager;
use LindenCMS\Cms\Ui\Forms\Files\FileUploadedList;
use LindenCMS\Cms\Ui\Forms\Files\Message as FileMessage;

class HtmxController extends Controller
{
    public function __construct(
        private NodeRequestFactory $nodeFactory,
        private FileManager $fileManager,
    ) {
    }

    public function __invoke(NodeRequest $request, string $method)
    {
        return $this->{$method}($request);
    }

    private function addCollectionItem(NodeRequest $request)
    {
        if (!$request->has(['path', 'code'])) {
            abort(400, 'Missing required parameters (path, code) must be provided');
        }

        $node = $request->node();

        /** @var NodeCollection */
        $collection = $node->path($request->query('path'), true);

        return $collection->makeItem()->context($request->input('context', 'html.form'));
    }

    public function upload(NodeRequest $request)
    {
        $required = ['path', 'code'];
        if (!$request->has($required)) {
            abort(400, 'Missing required parameters (' . implode(',', $required) . ') must be provided');
        }

        $rootNode = $request->node();

        /** @var FileUploads */
        $fileUploads = $rootNode->path($request->query('path'), true);
        try {
            $request->validate(rules: [
                'files.*' => $fileUploads->_validation()->rules,
            ], attributes: [
                'files.*' => 'file :ordinal-position',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return new FileMessage(id: $request->messagesId, error: $request->flattenErrors($e->errors()));
        }

        $files = $this->fileManager->uploadFromRequest($request, $fileUploads->_file());

        return implode([
            new FileUploadedList(
                $request->uploadedListId,
                implode(array_map(fn($file) => $fileUploads->makeItem()->context('html.uploaded', [
                    'file' => $file,
                    ...$request->input('data', []),
                ]), $files))
            ),
            new FileMessage(id: $request->messagesId, success: ['File uploaded successfully']),
        ]);
    }
}
