<?php
/**
 * Created by PhpStorm.
 * User: mayara
 * Date: 5/16/17
 * Time: 9:27 PM
 */

namespace AppBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MaxPhotoConstraint extends Constraint
{
    public $message = 'You can only upload up to 5 photos.';


    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}