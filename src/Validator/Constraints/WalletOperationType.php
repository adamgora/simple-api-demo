<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class WalletOperationType extends Constraint
{
    public $message = 'Operation type is not allowed';
}