<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Video;
use AppBundle\Form\CommentType;
use AppBundle\Form\VideoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    
    public function newAction(Request $request, int $video_id){
        //check user logged in
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
    
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
    
        $form->handleRequest($request);
        
        if($request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()){
            $comment = $form->getData();
            
            /*
             * Properties
             */
            $comment->setDatetime(new \DateTime());
            $comment->setUser($this->getUser());
            
            $video = $em->getRepository("AppBundle:Video")->find($video_id);
            $comment->setVideo($video);
            /*
             * Save in DB
             */
            $em->persist($comment);
            $em->flush();
    
    
            return new Response(json_encode(array('status'=>'success')), 200);
        }
        
        return new Response(json_encode(array('status'=>'error')), 400);
        

    }
}
