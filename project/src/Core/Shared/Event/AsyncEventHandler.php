<?php

declare(strict_types=1);

namespace App\Core\Shared\Event;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(
    name: 'messenger.message_handler',
    attributes: ['from_transport' => 'async']
)]
interface AsyncEventHandler
{

}