<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VideoController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository('AppBundle:Video')->findBy(array(), array('datetime' => 'asc'));
        
        return $this->render('AppBundle::video/index.html.twig', [
            'videos' => $videos
        ]);
    }
    
    public function showAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $video = $em->getRepository('AppBundle:Video')->find($id, array('datetime' => 'asc'));
        $comments = $em->getRepository('AppBundle:Comment')->findByVideo($video, array('datetime' => 'asc'));
        
        return $this->render('AppBundle::video/show.html.twig', [
            'video' => $video,
            'comments' => $comments
        ]);
    }
}
