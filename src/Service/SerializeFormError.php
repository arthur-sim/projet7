<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class SerializeFormError {

    public function serializeErrors(Form $form): array
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
