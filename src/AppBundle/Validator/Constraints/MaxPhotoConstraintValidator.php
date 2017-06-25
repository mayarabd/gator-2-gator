<?php
/**
 * Created by PhpStorm.
 * User: mayara
 * Date: 5/16/17
 * Time: 9:34 PM
 */

namespace AppBundle\Validator\Constraints;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MaxPhotoConstraintValidator extends ConstraintValidator
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->repository = $doctrine->getManager()->getRepository('AppBundle:ItemPost');
    }

    /**
     * Validates if database already has the max number of photos (5)
     * for the itemPost
     * @param mixed $photos
     * @param Constraint $constraint
     */
    public function validate($photos, Constraint $constraint)
    {
        //finds current itemPostId
        $itemPostId = $this->context->getRoot()->getData()->getId();

        //checks if itemPost exists
        //in EditPost
        if ($itemPostId != null) {
            //gets current photos from the database
            $itemPostPhotos = $this->repository->find($itemPostId)->getPhotos();

            //checks if new uploads go over maximum photo number
            if (sizeof($photos) + sizeof($itemPostPhotos) > 5 ) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
            //in newItemPost
        } else {
            if (sizeof($photos) > 5) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}