<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 5/19/17
 * Time: 2:38 PM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class ItemBookmarkRepository extends EntityRepository
{
    public function findAllBookmarksByUser(User $user){
        return $this->createQueryBuilder('item_bookmark')
            ->andWhere('item_bookmark.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->execute();
    }
}