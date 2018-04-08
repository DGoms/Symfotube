<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 07/04/18
 * Time: 14:55
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\Video;
use AppBundle\Service\VideoService;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Psr\Log\LoggerInterface;

class VideoSubscriber implements EventSubscriber
{
    private $videoService;
    private $logger;

    public function __construct(VideoService $videoService, LoggerInterface $logger)
    {
        $this->videoService = $videoService;
        $this->logger = $logger;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof Video)
            return;

        $this->logger->info('pre persist');

        $this->logger->info(var_export($entity->getVideoName(), true));
        $this->logger->info(var_export($entity->getVideoFile(), true));

        $this->logger->info(var_export($entity->getThumbnailName(), true));
        $this->logger->info(var_export($entity->getThumbnailFile(), true));

    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof Video)
            return;

    }


}