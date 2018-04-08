<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VideoRepository")
 * @Vich\Uploadable
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
     * @var File
     *
     * @Vich\UploadableField(mapping="video", fileNameProperty="videoName")
     *
     * @Assert\NotBlank(message="Please, upload the video.", groups={"new"})
     * @Assert\File(
     *     mimeTypes={ "video/mp4" },
     *     maxSize = "1024M"
     * )
     */
    private $videoFile;


    /**
     * @var string
     *
     * @ORM\Column(name="videoFileName", type="string", length=255, unique=true)
     *
     */
    private $videoName;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="thumbnail", fileNameProperty="thumbnailName")
     *
     * @Assert\File(
     *     mimeTypes={ "image/jpeg", "image/png" },
     *     maxSize = "4M"
     * )
     */
    private $thumbnailFile;
    
    /**
     * @var string
     *
     * @ORM\Column(name="thumbnailFileName", type="string", length=255, unique=true)
     *
     */
    private $thumbnailName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetimetz")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetimetz")
     */
    private $updatedAt;

    /**
     * @var VideoCategory
     *
     * @ORM\ManyToOne(targetEntity="VideoCategory", inversedBy="videos")
     */
    private $category;
    
    /**
     * @var User
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

    /**
     * @var \View
     *
     * @ORM\OneToMany(targetEntity="View", mappedBy="video", cascade={"remove"})
     */
    private $views;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->nbViews = 0;
    }


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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $video
     */
    public function setVideoFile(File $video = null)
    {
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($video) {
            $this->videoFile = $video;
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getVideoFile()
    {
        return $this->videoFile;
    }

    /**
     * Set videoFileName
     *
     * @param string $videoName
     *
     * @return Video
     */
    public function setVideoName($videoName)
    {
        $this->videoName = $videoName;

        return $this;
    }

    /**
     * Get videoFileName
     *
     * @return string
     */
    public function getVideoName()
    {
        return $this->videoName;
    }
    
    /**
     * Set thumbnailFileName
     *
     * @param string $thumbnailName
     *
     * @return Video
     */
    public function setThumbnailName($thumbnailName)
    {
        $this->thumbnailName = $thumbnailName;
        
        return $this;
    }
    
    /**
     * Get thumbnailFileName
     *
     * @return string
     */
    public function getThumbnailName()
    {
        return $this->thumbnailName;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $thumbnail
     */
    public function setThumbnailFile(File $thumbnail = null)
    {
        $this->thumbnailFile = $thumbnail;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($thumbnail) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getThumbnailFile()
    {
        return $this->thumbnailFile;
    }

    /**
     * Add view
     *
     * @param \AppBundle\Entity\View $view
     *
     * @return Video
     */
    public function addView(View $view)
    {
        $this->views[] = $view;

        return $this;
    }

    /**
     * Remove view
     *
     * @param View $view
     * @return Video
     */
    public function removeView(View $view)
    {
        $this->views->removeElement($view);

        return $this;
    }

    /**
     * Get views
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $datetime
     *
     * @return Video
     */
    public function setCreatedAt($datetime)
    {
        $this->createdAt = $datetime;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $datetime
     *
     * @return Video
     */
    public function setUpdatedAt($datetime)
    {
        $this->updatedAt = $datetime;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get Category
     *
     * @return VideoCategory
     */
    public function getCategory(): VideoCategory
    {
        return $this->category;
    }

    /**
     * Set Category
     *
     * @param VideoCategory $category
     *
     * @return Video
     */
    public function setCategory(VideoCategory $category)
    {
        $this->category = $category;

        return $this;
    }
    
    /**
     * Set User
     *
     * @param User $user
     *
     * @return Video
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        
        return $this;
    }
    
    /**
     * Get User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Video
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        
        return $this;
    }
    
    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
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
            "nb_views" => $this->getNbViews(),
            "video" => $this->getVideoName(),
            "thumbnail" => $this->getThumbnailName(),
            "created_at" => $this->getCreatedAt(),
            "updated_at" => $this->getUpdatedAt()
        ];
    }
    
    public function toCompleteArray(){
        $array = $this->toArray();
        $array["user"] = $this->getUser()->toArray();
        
        return $array;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getTitle();
    }
}

