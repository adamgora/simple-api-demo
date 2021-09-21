<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Enum\WalletOperationTypeEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WalletOperationTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!in_array(strtolower($value), [WalletOperationTypeEnum::ADDITION, WalletOperationTypeEnum::SUBTRACTION], true)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}