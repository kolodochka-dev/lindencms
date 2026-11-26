<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Traits\HasAttributes;

abstract class LoadableNode extends Node
{
    use HasAttributes;

    public static function contextsDir()
    {
        return class_basename(self::class);
    }

    public function load()
    {
        // $this = static::make();

        /**
         * @var AppNode|AppNodeCollection $child
         */
        foreach ($this->getChildren() as $key => $child) {
            if ($loader = $child->_load()?->loader) {
                $child->setParent(null);
                $loader($child, $this);
                $child->setParent($this, $key);
            }
        }

        return $this;
    }
}
