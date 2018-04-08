<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 08/04/18
 * Time: 01:13
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\Video;
use AppBundle\Service\VideoService;
use Psr\Log\LoggerInterface;
use Vich\UploaderBundle\Event\Event;

class VideoFilesUploadSubscriber
{
    private $videoService;
    private $logger;

    public function __construct(VideoService $videoService, LoggerInterface $logger)
    {
        $this->videoService = $videoService;
        $this->logger = $logger;
    }

    public function onVichUploaderPreUpload(Event $event)
    {
        $entity = $event->getObject();
        $mapping = $event->getMapping();

        if(!$entity instanceof Video)
            return;

        // do your stuff with $object and/or $mapping...
    }
}