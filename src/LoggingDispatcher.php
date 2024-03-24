<?php

namespace App;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Throwable;

final readonly class LoggingDispatcher implements EventDispatcherInterface
{

    public function __construct(
        private EventDispatcherInterface $dispatcher,
        // di сам подтянет стандартный симфоневский логгер
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws Throwable
     */
    public function dispatch(object $event): object
    {
        $this->logger->debug('Before event', [
            'event' => $event
        ]);

        try {
            $modifiedEvent = $this->dispatcher->dispatch($event);
        } catch (Throwable $exception) {
            $this->logger->critical('Something went wrong', [
                'event' => $event,
                'exception' => $exception
            ]);

            throw $exception;
        }

        $this->logger->info('After event', [
            'event' => $event
        ]);

        return $modifiedEvent;
    }
}