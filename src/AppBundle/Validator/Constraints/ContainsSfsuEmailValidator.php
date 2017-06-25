<?php
/**
 * Created by PhpStorm.
 * User: chengjiu
 * Date: 4/24/17
 * Time: 12:55 PM
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

class ContainsSfsuEmailValidator extends ConstraintValidator
{
    public function validate($userEmail, Constraint $constraint)
    {
        $index = -1;
        $emailSubString='';
        $sfsuEmail1 = '@sfsu.edu';
        $sfsuEmail2 = '@mail.sfsu.edu';

        for($i=0; $i<strlen($userEmail);$i++ ){
            if($userEmail[$i] == '@'){
                $index = $i;
            }
        }
        $emailSubString = substr($userEmail,$index);

        if ( (strcasecmp($sfsuEmail1, $emailSubString) != 0) && (strcasecmp($sfsuEmail2, $emailSubString) != 0)) {
            //error: not sfsu email
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}