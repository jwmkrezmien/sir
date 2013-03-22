<?php

namespace Pwc\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ComplexPassword extends Constraint
{
    public $message = 'pwc_user.new_password.lack_complexity';
}