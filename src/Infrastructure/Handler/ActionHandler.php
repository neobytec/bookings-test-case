<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler;

use App\Application\Actions\UseCases\ProcessActionUseCase;
use App\Infrastructure\Request\ActionRequest;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ActionHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ProcessActionUseCase $processActionUseCase
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $actionRequest = ActionRequest::createFromRequest($request);

        $this->processActionUseCase->__invoke($actionRequest);

        return new JsonResponse([], 200);
    }
}
