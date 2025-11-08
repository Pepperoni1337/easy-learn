<?php

declare(strict_types=1);

namespace App\Core\Shared\Query;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * @template TQuery of object
 * @template TResult
 */
#[AutoconfigureTag('messenger.message_handler', ['bus' => 'query.bus'])]
interface QueryHandler
{
}
