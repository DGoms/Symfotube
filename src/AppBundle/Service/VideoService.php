<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 07/04/18
 * Time: 14:46
 */

namespace AppBundle\Service;

//require '../../../vendor/autoload.php';

use AppBundle\Entity\Video;
use FFMpeg\Coordinate\TimeCode;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
// Use the FFMpeg tool
use FFMpeg\FFMpeg;

class VideoService
{
    private $videoDirectory;
    private $thumbnailDirectory;

    public function __construct($videoDirectory, $thumbnailDirectory)
    {
        $this->videoDirectory = $videoDirectory;
        $this->thumbnailDirectory = $thumbnailDirectory;
    }

    public function generateAndSetThumbnailIfNotExist(Video $entity){
        if(is_null($entity->getThumbnailFile()) && !is_null($entity->getVideoFile())){
            $thumbnailFile = $this->generateThumbnailFromVideo($entity->getVideoFile(), 10);
            $entity->setThumbnailFile($thumbnailFile);
        }
    }

    public function generateThumbnailFromVideo(File $videoFile, int $seconds = 10): UploadedFile{
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($videoFile);

        $fileName = md5(uniqid()) . '.jpg';
        $fullPathThumb = sys_get_temp_dir() . '/' . $fileName;
        $frame = $video->frame(TimeCode::fromSeconds($seconds)); //Get the frame at 10 seconds
        $frame->save($fullPathThumb);

        return new UploadedFile($fullPathThumb, $fileName, 'image/jpeg', filesize($fullPathThumb), false, true);
    }

}