<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Attributes\Validation;

#[Database('string')]
#[Validation('email|nullable')]
class _Email extends _String {}
