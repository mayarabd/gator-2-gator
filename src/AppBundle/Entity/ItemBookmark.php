<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 5/19/17
 * Time: 12:38 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ItemBookmark
 *
 * @ORM\Table(name="bookmarks")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemBookmarkRepository")
 */

class ItemBookmark
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="bookmarks")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="ItemPost", inversedBy="bookmarks")
     */
    private $itemPost;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getItemPost()
    {
        return $this->itemPost;
    }

    /**
     * @param mixed $itemPost
     */
    public function setItemPost($itemPost)
    {
        $this->itemPost = $itemPost;
    }


}