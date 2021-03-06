<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Form\FormInterface;

class AbstractApiController extends AbstractController
{
    private $serializer;
    
    public function __construct(SerializerInterface $serializer){
        $this->serializer = $serializer;
    }
    
    protected function json($data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        
            $json = $this->serializer->serialize($data, 'json');

            return new JsonResponse($json, $status, $headers, true);
        
    }
    
    public function serializeErrors(FormInterface $form): array
	{
		$errors = [];
		foreach ($form->getErrors() as $formError) {
			$errors['globals'][] = $formError->getMessage();
		}
		foreach ($form->all() as $childForm) {
			if ($childForm instanceof FormInterface) {
				if ($childErrors = $this->subSerializeErrors($childForm)) {
					$errors['fields'][$childForm->getName()] = $childErrors;
				}
			}
		}
		return $errors;
	}
	private function subSerializeErrors(FormInterface $form): array
	{
		$errors = [];
		foreach ($form->getErrors() as $error) {
			$errors[] = $error->getMessage();
		}
		foreach ($form->all() as $childForm) {
			if ($childForm instanceof FormInterface) {
				if ($childErrors = $this->serializeErrors($childForm)) {
					$errors[$childForm->getName()] = $childErrors;
				}
			}
		}
		return $errors;
	}
}