<?php

namespace App;

use Symfony\Contracts\EventDispatcher\Event;

final class TestEvent extends Event
{
    public function __construct(
        private readonly string $message
    ) {
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}