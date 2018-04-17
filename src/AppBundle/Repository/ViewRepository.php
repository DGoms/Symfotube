<?php

namespace AppBundle\Repository;
use AppBundle\Entity\User;
use AppBundle\Entity\Video;
use AppBundle\Entity\View;

/**
 * ViewedRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ViewRepository extends \Doctrine\ORM\EntityRepository
{
    public function getView(User $user = null, Video $video): View{
        $id = $this->isExist($user, $video);

        if($id == -1){
            return View::withUserVideo($user, $video);
        }else{
            $view = $this->findOneById($id);
            $view->setDatetime(new \DateTime());
            return $view;
        }
    }

    /**
     * Check if the user has viewed the video
     * @param User $user
     * @param Video $video
     * @return int return the id of view or -1
     */
    public function isExist(User $user = null, Video $video): int{
        if(!is_null($user)) {
            foreach ($user->getViews() as $view) {
                if ($view->getVideo()->getId() === $video->getId()) {
                    return $view->getId();
                }
            }
        }

        return -1;
    }
}
