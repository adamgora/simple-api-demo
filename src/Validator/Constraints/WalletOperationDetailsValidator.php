<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WalletOperationDetailsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!isset($value['amount']) || !filter_var($value['amount'], FILTER_VALIDATE_INT)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}