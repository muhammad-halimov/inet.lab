<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

class LogRequestAndResponseEventListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelTerminate(TerminateEvent $event)
    {
//        $request = $event->getRequest();
//        $response = $event->getResponse();
//
//        $this->logger->info('data', [
//            'route' => $request->getMethod() . ' ' . $request->getRequestUri(),
//            'status' => $response->getStatusCode(),
//            'request body' => json_decode($request->getContent(), true),
//            'response' => json_decode($response->getContent(), true),
//            'headers' => $request->headers->all(),
//        ]);
    }
}