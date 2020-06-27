<?php

namespace App\Exception;


use Symfony\Component\Form\FormInterface;

class FormValidateFailedException extends \Exception
{
    private $formRequest;

    public function __construct(FormInterface $form)
    {
        $this->formRequest = $form;
    }

    public function getForm(): FormInterface
    {
        return $this->formRequest;
    }

}