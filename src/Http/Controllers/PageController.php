<?php

namespace LindenCMS\Cms\Http\Controllers;

use LindenCMS\Cms\Http\Controllers\Controller;
use LindenCMS\Cms\Nodes\File;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    public function __invoke(Request $request, $handler)
    {
        $page = $handler->load($request);

        if (!$page) {
            $handler->notFound();
        }

        return $page->render();
    }
}
