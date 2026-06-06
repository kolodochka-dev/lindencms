<?php

namespace LindenCMS\Cms\Contracts;

use LindenCMS\Core\Node;

interface NodeRequestConract
{
    public function node(): ?Node;
}