<?php

namespace App\Normalizer;

use Symfony\Component\HttpFoundation\Response;
use App\Exception\FormErrorException;
use App\Service\SerializeFormError;

class FormErrorExceptionNormalizer extends AbstractNormalizer
{
    private $serializeFormError;
    
    public function __construct( SerializeFormError $serializeFormError) {
        $this->serializeFormError=$serializeFormError;
    }
    
    public function normalize(\Exception $exception)
    {
        if(!exception instanceOf FormErrorException){
            return;
        }
        
        $result['code'] = Response::HTTP_BAD_REQUEST;

        $result['body'] = [
            'code' => Response::HTTP_BAD_REQUEST,
            'formError' => $this->serializeFormError->serializeErrors($exception->getForm())
            
        ];

        return $result;
    }

    protected function getSupportedExceptions(): array {
        return [
            FormErrorException::class
        ];
    }

}