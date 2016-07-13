<?php

namespace Snt\Capi\Http\Exception;

final class HttpExceptionReason
{
    /**
     * @var bool
     */
    private $notFoundError;

    /**
     * @param bool $notFoundError
     */
    private function __construct($notFoundError)
    {
        $this->notFoundError = $notFoundError;
    }

    /**
     * @return HttpExceptionReason
     */
    public static function createForNotFoundError()
    {
        return new self(true);
    }

    /**
     * @return bool
     */
    public function isNotFoundError()
    {
        return $this->notFoundError;
    }
}
