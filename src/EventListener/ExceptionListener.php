<?php

namespace App\EventListener;

use App\Normalizer\NormalizerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use JMS\Serializer\SerializerInterface;

class ExceptionListener
{
    private $normalizers;
    private $serializer;
    
    
    public function __construct(iterable $normalizers, SerializerInterface $serializer)
    {
//        print_r($normalizers);
        $this->normalizers = $normalizers;
        $this->serializer = $serializer;
        
    }
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
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


}