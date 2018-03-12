<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 11/03/18
 * Time: 23:17
 */

namespace AppBundle\Service;


use AppBundle\Entity\Video;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VideoThumbnailUploader
{
    private $videoDirectory;
    private $thumbnailDirectory;

    public function __construct($videoDirectory, $thumbnailDirectory)
    {
        $this->videoDirectory = $videoDirectory;
        $this->thumbnailDirectory = $thumbnailDirectory;
    }

    public function upload(Video $video)
    {
        if($video->getVideo() instanceof UploadedFile){
            $video->setVideo($this->uploadVideo($video->getVideo()));
        }

        if($video->getThumbnail() instanceof UploadedFile){
            $video->setThumbnail($this->uploadThumbnail($video->getThumbnail()));
        }

        return $video;
    }

    public function uploadVideo(UploadedFile $file){
        return $this->moveFile($this->getVideoDirectory(), $file);
    }

    public function uploadThumbnail(UploadedFile $file){
        return $this->moveFile($this->getThumbnailDirectory(), $file);
    }

    private function moveFile(string $dir, UploadedFile $file){
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($dir, $fileName);
        return $fileName;
    }

    public function getVideoDirectory()
    {
        return $this->videoDirectory;
    }

    public function getThumbnailDirectory()
    {
        return $this->thumbnailDirectory;
    }
}