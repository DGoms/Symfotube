<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 09/04/18
 * Time: 16:27
 */

namespace AppBundle\Controller;


use AppBundle\Entity\VideoCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VideoCategoryController extends Controller
{
    public function listVideosAction(Request $request, string $name){
        $videoCategory = $this->getDoctrine()->getRepository('AppBundle:VideoCategory')->findOneByName($name);

        $title = "Category not found";
        $videos = [];

        if($videoCategory){
            $title = $videoCategory->getName();
            $videos = $this->getDoctrine()->getRepository('AppBundle:Video')->findByCategory($videoCategory->getId());
        }

        return $this->render('@App/video/list_videos.html.twig', array(
            'title' => $title,
            'videos' => $videos,
        ));
    }
}