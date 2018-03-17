<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 17/03/18
 * Time: 16:20
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\Comment;
use AppBundle\Entity\Video;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\Tests\Compiler\D;

class CreateUpdateAtSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if($entity instanceof Video || $entity instanceof Comment){
            $entity->setCreatedAt(new \DateTime());
            $entity->setUpdatedAt(new \DateTime());
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if($entity instanceof Video || $entity instanceof Comment){
            $entity->setUpdatedAt(new \DateTime());
        }
    }
}