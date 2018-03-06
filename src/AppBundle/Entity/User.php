<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $last_name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $first_name;
    
    /**
     * @var \Video
     *
     * @ORM\OneToMany(targetEntity="Video", mappedBy="user")
     */
    private $videos;
    
    /**
     * @var \Comment
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     */
    private $comments;
    
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Set last_name
     *
     * @param string $last_name
     *
     * @return User
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        
        return $this;
    }
    
    /**
     * Get last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }
    
    /**
     * Set first_name
     *
     * @param string $first_name
     *
     * @return User
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        
        return $this;
    }
    
    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }
    
    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;
        
        return $this;
    }
    
    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }
    
    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    /**
     * Add video
     *
     * @param \AppBundle\Entity\Video $video
     *
     * @return User
     */
    public function addVideo(\AppBundle\Entity\Video $video)
    {
        $this->videos[] = $video;
        
        return $this;
    }
    
    /**
     * Remove video
     *
     * @param \AppBundle\Entity\Video $video
     */
    public function removeVideo(\AppBundle\Entity\Video $video)
    {
        $this->videos->removeElement($video);
    }
    
    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }
    
    public function toArray(){
        return [
            "id" => $this->getId(),
            "username" => $this->getUsername(),
            "email" => $this->getEmail(),
            "first_name" => $this->getFirstName(),
            "last_name" => $this->getLastName(),
        ];
    }
    
    public function toCompleteArray(){
        $array = $this->toArray();
        //$array["user"] = $this->getUser()->toArray();
        
        return $array;
    }
}