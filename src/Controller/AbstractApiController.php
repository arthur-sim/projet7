<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerInterface;

class AbstractApiController extends AbstractController
{
    private $serializer;
    
    public function __construct(SerializerInterface $serializer){
        $this->serializer = $serializer;
    }
    
    protected function json($data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        var_dump($this->serializer);
        if ($this->container->has('jms_serializer')) {
            $json = $this->container->get('jms_serializer')->serialize($data, 'json', array_merge([
                'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
            ], $context));

            return new JsonResponse($json, $status, $headers, true);
        }

        return new JsonResponse($data, $status, $headers);
    }
}