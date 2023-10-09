<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidateRoleValidator extends ConstraintValidator
{
    const ROLES = ['ROLE_ADMIN', 'ROLE_USER'];

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValidateRole) {
            throw new UnexpectedTypeException($constraint, ValidateRole::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_array($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'array');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }

        foreach ($value as $role) {
            if (!in_array($role, self::ROLES)) {
                $this->context->buildViolation($constraint->message)
                    ->setCode('r1o2l3e4')
                    ->addViolation();
            }
        }
    }
}
