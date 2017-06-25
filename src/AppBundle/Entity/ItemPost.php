<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints as MaxPhotoConstraint;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ItemPost
 *
 * @ORM\Table(name="item_post")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemPostRepository")
 */
class ItemPost
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="itemposts")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="ItemBookmark", mappedBy="itemPost", orphanRemoval=true)
     */
    private $bookmarks;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="postDate", type="datetime")
     */
    private $postDate;

    /**
     * @ORM\OneToMany(targetEntity="ItemPostPhoto", mappedBy="itemPost", cascade={"all"})
     */
    private $photos;

    /**
     * @Assert\All({
     *     @Assert\Image(
     *     maxSize = "10M",
     *     maxSizeMessage = "Image is too large. Maximum allowed size is 10M")
     * })
     * @MaxPhotoConstraint\MaxPhotoConstraint
     */
    private $photoList;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->photoList = new ArrayCollection();
        $this->bookmarks = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|ItemBookmark[]
     */
    public function getBookmarks()
    {
        return $this->bookmarks;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Get photo list
     * @return mixed
     */
    public function getPhotoList()
    {
        return $this->photoList;
    }

    /** Set photos
     * @param $photoList
     */
    public function setPhotoList($photoList)
    {
        $this->photoList = $photoList;
    }


    /**
     * Get id
     *
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
    public function setUser(User $user)
    {
        $this->user = $user;
    }



    /**
     * Set name
     *
     * @param string $name
     *
     * @return ItemPost
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return ItemPost
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ItemPost
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return ItemPost
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     *
     * @return ItemPost
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }


    /**
     * Get postDate
     *
     * @return \DateTime
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * a path to photo, itempost object
     * @param $path String
     */
    public function addPhoto($path) {
        $photo = new ItemPostPhoto($path, $this);
        $this->photos->add($photo);

    }
}
