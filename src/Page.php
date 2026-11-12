<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Exceptions\PageLoadException;
use LindenCMS\Cms\Traits\HasAttributes;
use Illuminate\Http\Request;

abstract class Page extends Node
{
    use HasAttributes;

    public function __invoke(Request $request)
    {
        $page = static::make();

        /**
         * @var AppNode|AppNodeCollection $child
         */
        foreach ($page->getChildren() as $key => $child) {
            if ($loader = $child->_load()?->fromRequest) {
                $child->setParent(null);
                try {
                    $loader($child, $request);
                } catch (PageLoadException $e) {
                    return $e->getResponse() ?? abort(404);
                }

                $child->setParent($page, $key);
            }
        }

        return $page->ctx()->html_page();
    }
}
