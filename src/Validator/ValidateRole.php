<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * Class ValidateRole
 * @package App\Validator
 * @Annotation
 */
#[\Attribute] class ValidateRole extends Constraint
{
    public string $message = 'Un des rôles renseigné est incorrect.';
    public string $mode = 'strict';
}
