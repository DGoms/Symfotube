<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Video;
use AppBundle\Form\CommentType;
use AppBundle\Form\VideoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
            //$em->persist($comment);
            //$em->flush();
            
            
    
            return new JsonResponse($comment->toCompleteArray(), Response::HTTP_OK);
            //return new Response(json_encode($comment), Response::HTTP_OK);
        }
        
        return new Response(json_encode(array('status'=>'error')), Response::HTTP_BAD_REQUEST);
    }
    
    public function getAction(Request $request, int $video_id, int $first_result){
        $em = $this->getDoctrine()->getManager();
        
        $comments = $em->getRepository('AppBundle:Comments')->getByVideo($video_id, $first_result);
        
        return new Response(json_encode($comments), 200);
    }
}
