<?php
/**
 * Created by PhpStorm.
 * User: mayara
 * Date: 4/11/17
 * Time: 7:26 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="item_post_photo")
 * @ORM\Entity()
 */
class ItemPostPhoto {

   /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(name="id", type="integer", nullable=false)
    */
    private $id;

   /**
    * @ORM\Column(name="path", type="text")
    */
    private $path;

   /**
    * @ORM\ManyToOne(targetEntity="ItemPost", inversedBy="photos")
    * @ORM\JoinColumn(name="item_post_id", referencedColumnName="id", nullable=false)
    */
    private $itemPost;

   /**
    * ItemPostPhoto constructor.
    * path to photo, item post object
    * @param $path String
    * @param $itemPost ItemPost
    */
    public function __construct($path, $itemPost)
    {
        $this->path = $path;
        $this->itemPost = $itemPost;
    }

    /**
     * photo id
     * @return Integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getPath()
    {
        return $this->path;
    }

   /**
    * @param mixed $path
    */
    public function setPath($path)
    {
        $this->path = $path;
    }

   /**
    * photo's item post
    * @return ItemPost
    */
    public function getItemPost()
    {
        return $this->itemPost;
    }

}