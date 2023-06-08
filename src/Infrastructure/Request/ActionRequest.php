<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use App\Domain\Actions\Models\ActionEnum;
use App\Domain\Actions\Ports\ActionDTOInterface;
use App\Domain\Exceptions\ValidationException;
use DateTime;
use Psr\Http\Message\ServerRequestInterface;

class ActionRequest implements ActionDTOInterface
{
    private const DATETIME_FORMAT = 'Y-m-d';
    private const KEY_REFERENCE   = 'reference';
    private const KEY_ACTION      = 'action';
    private const KEY_CHECKIN     = 'check_in';
    private const KEY_CHECKOUT    = 'check_out';
    private const KEY_PEOPLE      = 'people';

    public function __construct(
        private readonly string $reference,
        private readonly ActionEnum $action,
        private readonly DateTime $checkIn,
        private readonly DateTime $checkOut,
        private readonly int $people,
    ) {
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getAction(): ActionEnum
    {
        return $this->action;
    }

    public function getCheckIn(): DateTime
    {
        return $this->checkIn;
    }

    public function getCheckOut(): DateTime
    {
        return $this->checkOut;
    }

    public function getPeople(): int
    {
        return $this->people;
    }

    public static function createFromRequest(ServerRequestInterface $request): self
    {
        $body = $request->getParsedBody();

        if (
            ! isset($body[self::KEY_REFERENCE])
            || ! isset($body[self::KEY_ACTION])
            || ! isset($body[self::KEY_CHECKIN])
            || ! isset($body[self::KEY_CHECKOUT])
            || ! isset($body[self::KEY_PEOPLE])
        ) {
            throw ValidationException::create(
                'The fields: reference, action, check_in, check_out, people are mandatory'
            );
        }

        $action = match ($body[self::KEY_ACTION]) {
            ActionEnum::Modification->name => ActionEnum::Modification,
            ActionEnum::Cancellation->name => ActionEnum::Cancellation,
            default => ActionEnum::Confirmation
        };

        /** @var DateTime|false $checkIn */
        $checkIn = DateTime::createFromFormat(self::DATETIME_FORMAT, $body[self::KEY_CHECKIN]);
        /** @var DateTime|false $checkOut */
        $checkOut = DateTime::createFromFormat(self::DATETIME_FORMAT, $body[self::KEY_CHECKOUT]);

        if (! $checkIn || ! $checkOut) {
            throw ValidationException::create(
                'The fields: check_in and check_out must be dates with format 2023-06-08'
            );
        }

        return new self(
            $body[self::KEY_REFERENCE],
            $action,
            $checkIn,
            $checkOut,
            $body[self::KEY_PEOPLE],
        );
    }
}
