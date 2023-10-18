<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * Class ValidateRole
 * @package App\Validator
 * @Annotation
 */
#[\Attribute] class ValidateSexe extends Constraint
{
    public string $message = 'Le sexe renseigné est incorrect.';
    public string $mode = 'strict';
}
