<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\Page\Html\PageContext;
use LindenCMS\Cms\Exceptions\LoadException;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Traits\HasAttributes;
use Illuminate\Http\Request;

abstract class Page extends Node
{
    use HasAttributes;

    public function __construct()
    {
        $this->contexts = [
            // Html
            'html.page' => PageContext::class,
        ];
    }

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
                } catch (LoadException $e) {
                    return $e->getResponse() ?? abort(404);
                }

                $child->setParent($page, $key);
            }
        }

        return $page->context('html.page');
    }

    // public static function httpCallback(): \Closure
    // {
    //     return function (Request $request) {
    //         $page = static::make();

    //         /**
    //          * @var AppNode|AppNodeCollection $child
    //          */
    //         foreach ($page->getChildren() as $key => $child) {
    //             if ($loader = $child->_load()?->fromRequest) {
    //                 $child->setParent(null);

    //                 try {
    //                     $loader($child, $request);
    //                 } catch (LoadException $e) {
    //                     return $e->getResponse() ?? abort(404);
    //                 }

    //                 $child->setParent($page, $key);
    //             }
    //         }

    //         return $page->context('html.page');
    //     };
    // }
}
