<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class ErrorException extends Exception implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(string $message): self
    {
        $validationException         = new self($message);
        $validationException->status = 500;
        $validationException->detail = $message;
        $validationException->type   = 'https://example.com/api/doc/domain-exception';
        $validationException->title  = 'Unknown error';
        return $validationException;
    }
}
