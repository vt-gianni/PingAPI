<?php

namespace App\Event;

use App\Entity\Oops;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class OopsSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', 0],
        ];
    }

    /**
     * @throws Exception
     */
    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $status = $response->getStatusCode();
        $requestContent = $event->getRequest()->getContent();

        if ($status > 400 && $status !== 401) {
            $oops = new Oops();
            $oops->setBody($requestContent);
            $oops->setHeaders($event->getRequest()->headers->all());
            $oops->setIncidentDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $oops->setResponse($response->getContent());
            $oops->setStatus($status);
            $oops->setUrl($event->getRequest()->getRequestUri());


            $this->entityManager->persist($oops);
            $this->entityManager->flush();
        }
    }
}
