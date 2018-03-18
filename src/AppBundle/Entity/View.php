<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Viewed
 *
 * @ORM\Table(name="view")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ViewRepository")
 */
class View
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
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetimetz")
     */
    private $datetime;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="views")
     */
    private $user;

    /**
     * @var Video
     *
     * @ORM\ManyToOne(targetEntity="Video", inversedBy="views")
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
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return View
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
     * Set user
     *
     * @param \stdClass $user
     *
     * @return View
     */
    public function setUser($user): View
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }

    /**
     * Set video
     *
     * @param \stdClass $video
     *
     * @return View
     */
    public function setVideo($video): View
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return Video
     */
    public function getVideo(): Video
    {
        return $this->video;
    }
}

