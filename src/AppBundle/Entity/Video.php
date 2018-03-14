<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VideoRepository")
 */
class Video
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(message="Please enter a title")
     * @Assert\Length(
     *     min=5,
     *     max=255
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     * @Assert\Length(
     *     max="1000"
     * )
     */
    private $description;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="videoFileName", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(message="Please, upload the video.", groups={"new"})
     * @Assert\File(
     *     mimeTypes={ "video/mp4" },
     *     maxSize = "1024M"
     * )
     */
    private $video;
    
    /**
     * @var string
     *
     * @ORM\Column(name="thumbnailFileName", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(message="Please, upload the thumbnail.", groups={"new"})
     * @Assert\File(
     *     mimeTypes={ "image/jpeg", "image/png" },
     *     maxSize = "4M"
     * )
     */
    private $thumbnail;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nbViews", type="integer", options={"default" : 0})
     */
    private $nbViews;
    
    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="videos")
     */
    private $user;
    
    /**
     * @var \Comment
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="video", cascade={"remove"})
     */
    private $comments;


    /* ***********************************************************
     *      Getters & Setters
     * ***********************************************************/

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
     * Set title
     *
     * @param string $title
     *
     * @return Video
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Video
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
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Video
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        
        return $this;
    }
    
    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set videoFileName
     *
     * @param string $video
     *
     * @return Video
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get videoPath
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }
    
    /**
     * Set thumbnailFileName
     *
     * @param string $thumbnail
     *
     * @return Video
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        
        return $this;
    }
    
    /**
     * Get thumbnailPath
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
    
    /**
     * Set nbViews
     *
     * @param int $nbViews
     *
     * @return Video
     */
    public function setNbViews($nbViews)
    {
        $this->nbViews = $nbViews;
        
        return $this;
    }
    
    /**
     * Get nbViews
     *
     * @return int
     */
    public function getNbViews()
    {
        return $this->nbViews;
    }
    
    /**
     * Set User
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Video
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;
        
        return $this;
    }
    
    /**
     * Get User
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return Video
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

    /* ***********************************************************
     *      Functions
     * ***********************************************************/

    /**
     * Is the given User the author of this Comment ?
     * @param User $user
     * @return bool
     */
    public function isAuthor(User $user = null): bool {
        return $user && $user->getEmail() == $this->getUser()->getEmail();
    }
    
    public function toArray(){
        return [
            "id" => $this->getId(),
            "title" => $this->getTitle(),
            "description" => $this->getDescription(),
            "datetime" => $this->getDatetime(),
            "nb_views" => $this->getNbViews(),
        ];
    }
    
    public function toCompleteArray(){
        $array = $this->toArray();
        $array["user"] = $this->getUser()->toArray();
        
        return $array;
    }
}

