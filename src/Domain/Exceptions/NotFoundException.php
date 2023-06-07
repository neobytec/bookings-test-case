<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class NotFoundException extends Exception implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    public static function create(string $message): self
    {
        $validationException         = new self($message);
        $validationException->status = 404;
        $validationException->detail = $message;
        $validationException->type   = 'https://example.com/api/doc/domain-exception';
        $validationException->title  = 'Not found';
        return $validationException;
    }
}
