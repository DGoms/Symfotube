<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VideoCategory
 *
 * @ORM\Table(name="video_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VideoCategoryRepository")
 */
class VideoCategory
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255, options={"default" : "info"})
     *
     */
    private $icon;

    /**
     * @var \Video
     *
     * @ORM\OneToMany(targetEntity="Video", mappedBy="category")
     */
    private $videos;

    /**
     * VideoCategory constructor.
     */
//    public function __construct()
//    {
//        $this->icon = 'info';
//    }


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
     * Set name
     *
     * @param string $name
     *
     * @return VideoCategory
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
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;
    }



    /**
     * Add video
     *
     * @param Video $video
     *
     * @return VideoCategory
     */
    public function addVideo(Video $video)
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param Video $video
     */
    public function removeVideo(Video $video)
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

    public function __toString(): string
    {
        return $this->name ? $this->name : '';
    }


}

