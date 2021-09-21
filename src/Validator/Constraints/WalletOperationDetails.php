<?php
declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class WalletOperationDetails extends Constraint
{
    public $message = 'Operation details not configured properly';
}