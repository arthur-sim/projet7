<?php

namespace App\EventSubscriber;

use App\Normalizer\NormalizerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private $normalizers;
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->normalizers = [];
    }
    public function processException(GetResponseForExceptionEvent $event)
    {
        return;
        $result = null;
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($event->getException())) {
                $result = $normalizer->normalize($event->getException());
                
                break;
            }
        }
        
        if (null == $result) {
            $result['code'] = Response::HTTP_INTERNAL_SERVER_ERROR;

            $result['body'] = [
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'internal server error'
            ];
        }

         $body = $this->serializer->serialize($result['body'], 'json');

        $event->setResponse(new Response($body, $result['code']));
    }

    public function addNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [['processException', 255]]
        ];
    }
}