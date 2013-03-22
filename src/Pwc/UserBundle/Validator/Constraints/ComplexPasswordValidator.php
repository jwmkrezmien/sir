<?php

namespace Pwc\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ComplexPasswordValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $compliance = 0;

        $r1='/[A-Z]/';                      // Uppercase
        $r2='/[a-z]/';                      // Lowercase
        $r3='/[!@#$%^&*()\-_=+{};:,<.>]/';  // Special chars
        $r4='/[0-9]/';                      // Numbers

        // At least 1 uppercase character
        if(preg_match_all($r1, $value, $o) >= 1) $compliance++;

        // At least 2 lowercase characters
        if(preg_match_all($r2, $value, $o) >= 2) $compliance++;

        // At least 1 special character
        if(preg_match_all($r3, $value, $o) >= 1) $compliance++;

        // At least 2 numbers
        if(preg_match_all($r4, $value, $o) >= 2) $compliance++;

        if ($compliance <= 3) $this->context->addViolation($constraint->message, array('%compliance%' => $compliance));
    }
}