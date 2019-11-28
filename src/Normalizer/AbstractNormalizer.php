<?php

namespace App\Normalizer;

abstract class AbstractNormalizer implements NormalizerInterface
{


    public function supports(\Exception $exception)
    {
        return in_array(get_class($exception), $this->exceptionTypes);
    }
    
    abstract protected function getSupportedExceptions():array;
}