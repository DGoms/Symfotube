<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
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
     * @ORM\Column(name="videoPath", type="string", length=255, unique=true)
     */
    private $videoPath;
    
    /**
     * @var string
     *
     * @ORM\Column(name="thumbnailPath", type="string", length=255, unique=true)
     */
    private $thumbnailPath;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nbViews", type="integer")
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
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="video")
     */
    private $comments;


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
     * @return Comment
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
     * Set videoPath
     *
     * @param string $videoPath
     *
     * @return Video
     */
    public function setVideoPath($videoPath)
    {
        $this->videoPath = $videoPath;

        return $this;
    }

    /**
     * Get videoPath
     *
     * @return string
     */
    public function getVideoPath()
    {
        return $this->videoPath;
    }
    
    /**
     * Set thumbnailPath
     *
     * @param string $thumbnailPath
     *
     * @return Video
     */
    public function setThumbnailPath($thumbnailPath)
    {
        $this->thumbnailPath = $thumbnailPath;
        
        return $this;
    }
    
    /**
     * Get thumbnailPath
     *
     * @return string
     */
    public function getThumbnailPath()
    {
        return $this->thumbnailPath;
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
}

