<?php


namespace App\Service;

use App\Entity\Program;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    public function validate(ValidatorInterface $validator)
    {
        $program = new Program();

        $errors = $validator->validate($program);

        if(count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        return new Response('');

    }


}
