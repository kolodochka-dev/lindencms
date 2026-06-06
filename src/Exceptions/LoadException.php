<?php

namespace LindenCMS\Cms\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class LoadException extends \Exception
{
    public function __construct(
        protected Response|RedirectResponse|JsonResponse|null $response = null,
        string $message = "",
        int $code = 0
    ) {
        parent::__construct($message, $code);
    }

    public function getResponse(): Response|RedirectResponse|JsonResponse|null
    {
        return $this->response;
    }
}