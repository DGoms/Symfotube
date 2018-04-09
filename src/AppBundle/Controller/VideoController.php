<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Video;
use AppBundle\Entity\View;
use AppBundle\Form\CommentType;
use AppBundle\Form\VideoType;
use AppBundle\Service\VideoService;
use AppBundle\Service\VideoThumbnailUploader;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class VideoController extends Controller
{
    
//    public function indexAction(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $videos = $em->getRepository('AppBundle:Video')->findBy(array(), array('datetime' => 'desc'));
//
//        return $this->render('AppBundle::video/index.html.twig', [
//            'videos' => $videos
//        ]);
//    }

    public function listVideosAction(array $videos){
        return $this->render('AppBundle:video:list-videos.html.twig', [
            'videos' => $videos
        ]);
    }
    
    public function showAction(Request $request, Video $video){
        $em = $this->getDoctrine()->getManager();

        //View
        $view = $em->getRepository('AppBundle:View')->getView($this->getUser(), $video);
        if(!$video->isAuthor($this->getUser())){
            $em->persist($view);
            $em->flush();
        }

        //Comment form
        $comment = new Comment();
        $comment->setVideo($video);
        $commentForm = $this->createForm(CommentType::class, $comment);
        
        return $this->render('AppBundle::video/show.html.twig', [
            'video' => $video,
            'commentForm' => $commentForm->createView()
        ]);
    }
    
    public function newAction(Request $request, VideoService $videoService){
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video, array('validation_groups' => ['Default', 'new']));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $video->setUser($this->getUser());
            $videoService->generateAndSetThumbnailIfNotExist($video);

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('video_show', ['id' => $video->getId()]);
        }
    
        return $this->render('AppBundle::video/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction(Request $request, VideoService $videoService, Video $video){
        if(!$video->isAuthor($this->getUser()))
            throw $this->createAccessDeniedException("You can't edit this video");

        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $videoService->generateAndSetThumbnailIfNotExist($video);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('video_show', ['id' => $video->getId()]);
        }

        return $this->render('AppBundle::video/new.html.twig', [
            'video' => $video,
            'form' => $form->createView()
        ]);
    }

    public function deleteAction(Request $request, Video $video){
        if(!$video->isAuthor($this->getUser()))
            throw $this->createAccessDeniedException("You can't delete this video");

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('video_delete', array('id' => $video->getId())))
            ->setMethod('DELETE')
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($video);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('AppBundle:default:confirm_form.html.twig', [
            'message'=> "Are you sure you want to delete this video ?",
            'form' => $form->createView()
        ]);
    }
}
