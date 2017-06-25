<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsSfsuEmail extends Constraint{
    public $message = 'Sorry, you must use a valid SFSU email address to register.';

}