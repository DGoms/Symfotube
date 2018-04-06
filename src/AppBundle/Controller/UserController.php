<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/user", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function listUsersAction(array $users){
        return $this->render('AppBundle:user:list-users.html.twig', [
            'users' => $users
        ]);
    }

    public function historyAction(Request $request){
        $views = $this->getDoctrine()->getRepository('AppBundle:View')->findByUser($this->getUser(), array('datetime' => 'desc'));
        $videos = array();

        foreach ($views as $view){
            array_push($videos, $view->getVideo());
        }

        return $this->render('@App/video/list_videos.html.twig', [
            'title' => 'history',
            'videos' => $videos
        ]);
    }
}
