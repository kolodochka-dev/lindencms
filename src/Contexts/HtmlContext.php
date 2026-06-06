<?php

namespace LindenCMS\Cms\Contexts;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Templator\HasTemplator;

abstract class HtmlContext extends Context
{
    use HasTemplator;

    /**
     * Convert 'comments.seo.metaTitle as Comments Meta Ttitle' to the [comments.seo.metaTitle, 'Comments Meta Ttitle']
     * or 'comments.seo.metaTitle' to the [comments.seo.metaTitle, null]
     */
    public function pathAlias(string $input, string $aliasDelimiter = ' as '): array
    {
        $filter = str($input);
        if ($filter->contains($aliasDelimiter)) {
            return [
                $filter->before($aliasDelimiter)->toString(),
                $filter->after($aliasDelimiter)->toString()
            ];
        }

        return [$filter->toString(), null];
    }
}