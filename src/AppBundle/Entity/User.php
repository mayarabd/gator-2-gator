<?php

/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/8/16
 * Time: 7:45 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ParticipantInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Validator\Constraints as SFSUEmailConstraint;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="UsersTable")
 * @UniqueEntity(fields={"email"}, message="It looks like your already have an account!")
 * @UniqueEntity(fields={"username"}, message="Username is already taken")
 */
class User implements UserInterface, ParticipantInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @SFSUEmailConstraint\ContainsSfsuEmail
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank(groups={"Registration"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ItemPost", mappedBy="user", orphanRemoval=true)
     */
    private $itemposts;

    /**
     * @ORM\OneToMany(targetEntity="ItemBookmark", mappedBy="user", orphanRemoval=true)
     */
    private $bookmarks;

    public function __construct()
    {
        $this->bookmarks = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        if(!in_array('ROLE_USER', $roles)){
            //this adds ROLE_USER to the array, it does NOT overwrite the array
            $roles[] = 'ROLE_USER';
        }
        return $roles;
    }

    public function setRoles($roles)
    {
        if(!in_array('ROLE_USER', $roles)){
            //this adds ROLE_USER to the array, it does NOT overwrite the array
            $roles[] = 'ROLE_USER';
        }
        $this->roles = $roles;
    }

    public function addOneRole($role)
    {
        if(!in_array('ROLE_USER', $this->roles)){
            //this adds ROLE_USER to the array, it does NOT overwrite the array
            $roles[] = 'ROLE_USER';
        }
        $this->roles[] = $role;
    }

    public function removeOneRole($role)
    {
        unset($this->roles[array_search($role, $this->roles)]);
        if(!in_array('ROLE_USER', $this->roles)){
            //this adds ROLE_USER to the array, it does NOT overwrite the array
            $roles[] = 'ROLE_USER';
        }
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }

    /**
     * @return mixed
     */
    public function getItemposts()
    {
        return $this->itemposts;
    }

    /**
     * @param mixed $itemposts
     */
    public function setItemposts($itemposts)
    {
        $this->itemposts = $itemposts;
    }

    /**
     * @return ArrayCollection|ItemBookmark[]
     */
    public function getBookmarks()
    {
        return $this->bookmarks;
    }

    function __toString()
    {
        return (string)$this->username;
    }
}
