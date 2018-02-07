<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="text", type="string", length=1000)
     * @Assert\NotBlank(message="Please enter a text.")
     * @Assert\Length(
     *     min=5,
     *     max=1000,
     *     minMessage="The text is too short.",
     *     maxMessage="The text is too long."
     * )
     */
    private $text;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;
    
    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     */
    private $user;
    
    /**
     * @var \Video
     *
     * @ORM\ManyToOne(targetEntity="Video", inversedBy="comments")
     */
    private $video;


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
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
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
     * Set User
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Comment
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
     * Set Video
     *
     * @param \AppBundle\Entity\Video $video
     *
     * @return Comment
     */
    public function setVideo(\AppBundle\Entity\Video $video)
    {
        $this->video = $video;
        
        return $this;
    }
    
    /**
     * Get Video
     *
     * @return \AppBundle\Entity\Video
     */
    public function getVideo()
    {
        return $this->video;
    }
    
    public function toArray(){
        return [
            "id" => $this->getId(),
            "datetime" => $this->getDatetime(),
            "text" => $this->getText(),
        ];
    }
    
    public function toCompleteArray(){
        $array = $this->toArray();
        $array["user"] = $this->getUser()->toArray();
        $array["video"] = $this->getVideo()->toArray();
        
        return $array;
    }
}

