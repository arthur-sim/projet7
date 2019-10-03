<?php

namespace App\Exception;

use Symfony\Component\Form\FormInterface;


class FormErrorException extends \Exception{
    
    private  $form;
    
    public function __construct(FormInterface $form ,string $message = "", int $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->form=$form;
        
    }
    
    public function getForm() {
        return $this->form;
    }

    
    
}
