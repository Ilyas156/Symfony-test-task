<?php

namespace App\Controller\api\test\event;

use App\LoggingDispatcher;
use App\TestEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class TestController extends AbstractController
{
    public function __construct(
      private readonly LoggingDispatcher $dispatcher
    ) {
    }

    /**
     * @throws Throwable
     */
    public function test(Request $request): Response
    {
        $message = $request->query->get('message');

        if (is_null($message)) {
            return new Response('Сообщение не передано');
        }

        $this->dispatcher->dispatch(new TestEvent($message));

        return new Response('');
    }
}