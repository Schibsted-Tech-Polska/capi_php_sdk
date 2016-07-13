<?php

namespace Snt\Capi\Http\Exception;

use Exception;
use RuntimeException;

class HttpException extends RuntimeException
{
    /**
     * @var HttpExceptionReason|null
     */
    protected $httpExceptionReason;

    /**
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     * @param HttpExceptionReason|null $httpExceptionReason
     */
    public function __construct(
        $message = '',
        $code = 0,
        Exception $previous = null,
        HttpExceptionReason $httpExceptionReason = null
    ) {
        $this->httpExceptionReason = $httpExceptionReason;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return boolean
     */
    public function isNotFoundError()
    {
        return $this->httpExceptionReason instanceof HttpExceptionReason
            ? $this->httpExceptionReason->isNotFoundError()
            : false;
    }
}
