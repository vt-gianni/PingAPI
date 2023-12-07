<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidateSexeValidator extends ConstraintValidator
{
    const _VALUES = ['male', 'female'];

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValidateSexe) {
            throw new UnexpectedTypeException($constraint, ValidateSexe::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }

        if (!in_array($value, self::_VALUES)) {
            $this->context->buildViolation($constraint->message)
                ->setCode('s1e2x3e4')
                ->addViolation();
        }
    }
}
