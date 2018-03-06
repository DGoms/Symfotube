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

class VideoController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository('AppBundle:Video')->findBy(array(), array('datetime' => 'desc'));
        
        return $this->render('AppBundle::video/index.html.twig', [
            'videos' => $videos
        ]);
    }

    public function listVideosAction(array $videos){
        return $this->render('AppBundle:video:list-videos.html.twig', [
            'videos' => $videos
        ]);
    }
    
    public function showAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Get video & comments
        $video = $em->getRepository('AppBundle:Video')->find($id, array('datetime' => 'asc'));
        $comments = $em->getRepository('AppBundle:Comment')->getByVideo($video);
        
        //Increment nbViews
        $video->setNbViews($video->getNbViews() + 1);
        $em->persist($video);
        $em->flush();
        
        //Comment form
        $comment = new Comment();
        $comment->setVideo($video);
        $commentForm = $this->createForm(CommentType::class, $comment);
        
        return $this->render('AppBundle::video/show.html.twig', [
            'video' => $video,
            'comments' => $comments,
            'commentForm' => $commentForm->createView()
        ]);
    }
    
    public function newAction(Request $request){
        //check user logged in
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
    
        $video = new Video();
    
        $form = $this->createForm(VideoType::class, $video);
    
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid()){
            $video = $form->getData();
            
            /*
             * Properties
             */
            $video->setDatetime(new \DateTime());
            $video->setUser($this->getUser());
            $video->setNbViews(0);
            
            /*
             * FILES
             */
            $videoFile = $video->getVideo();
            $thumbnailFile = $video->getThumbnail();
            
            // Generate a unique name for the file before saving it
            $videoFileName = md5(uniqid()).'.'.$videoFile->guessExtension();
            $thumbnailFileName = md5(uniqid()).'.'.$thumbnailFile->guessExtension();
            
            // Move the file to the directory where brochures are stored
            $videoFile->move(
                $this->getParameter('videos_directory'),
                $videoFileName
            );
            
            $thumbnailFile->move(
                $this->getParameter('thumbnails_directory'),
                $thumbnailFileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $video->setVideo($videoFileName);
            $video->setThumbnail($thumbnailFileName);
            
            /*
             * Save in DB
             */
            $em->persist($video);
            $em->flush();
            
            
            return $this->redirectToRoute('video_show', ['id' => $video->getId()]);
        }
    
        return $this->render('AppBundle::video/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
