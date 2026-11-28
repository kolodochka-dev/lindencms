<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Load;
use LindenCMS\Cms\Attributes\LoadAll;
use LindenCMS\Cms\Attributes\LoadFirst;
use LindenCMS\Cms\Exceptions\PageLoadException;
use LindenCMS\Cms\Traits\HasAttributes;
use Illuminate\Http\Request;

abstract class Page extends Node
{
    use HasAttributes;

    public static function contextsDir()
    {
        return class_basename(self::class);
    }

    public function __invoke(Request $request)
    {
        $page = static::make();

        /**
         * @var AppNode|AppNodeCollection $child
         */
        foreach ($page->getChildren() as $key => $child) {
            $loader = null;
            foreach ($this->loaders() as $loaderAttribute) {
                if (isset($child->nodeAttributes[$loaderAttribute])) {
                    $loader = $child->nodeAttributes[$loaderAttribute];
                    break;
                }
            }

            if ($loader) {
                $loaderCallback = $loader?->loader;
                
                $child->setParent(null);
                try {
                    $loaderCallback($child, $page, $request);
                } catch (PageLoadException $e) {
                    return $e->getResponse() ?? abort(404);
                }

                $child->setParent($page, $key);
            }
        }

        return $page->ctx()->html_page();
    }

    protected function loaders()
    {
        return [
            Load::class,
            LoadFirst::class,
            LoadAll::class,
        ];
    }
}
