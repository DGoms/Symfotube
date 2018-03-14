<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Video;
use AppBundle\Form\CommentType;
use AppBundle\Form\VideoType;
use AppBundle\Service\VideoThumbnailUploader;
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
        //Increment nbViews
        $video->setNbViews($video->getNbViews() + 1);
        $this->getDoctrine()->getManager()->flush();

        //Comment form
        $comment = new Comment();
        $comment->setVideo($video);
        $commentForm = $this->createForm(CommentType::class, $comment);
        
        return $this->render('AppBundle::video/show.html.twig', [
            'video' => $video,
            'commentForm' => $commentForm->createView()
        ]);
    }
    
    public function newAction(Request $request, VideoThumbnailUploader $videoThumbnailUploader){
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video, array('validation_groups' => ['Default', 'new']));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $video->setDatetime(new \DateTime());
            $video->setUser($this->getUser());
            $video->setNbViews(0);
            $this->handleFiles($videoThumbnailUploader, $video, null, null);

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('video_show', ['id' => $video->getId()]);
        }
    
        return $this->render('AppBundle::video/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction(Request $request, VideoThumbnailUploader $videoThumbnailUploader, Video $video){
        if(!$video->isAuthor($this->getUser()))
            throw $this->createAccessDeniedException("You can't edit this video");

        $oldVideoFilename = $video->getVideo();
        $oldThumbFilename = $video->getThumbnail();

        $video->setVideo(new File($this->getParameter('videos_directory') . $video->getVideo()));
        $video->setThumbnail(new File($this->getParameter('thumbnails_directory') . $video->getThumbnail()));

        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $video = $this->handleFiles($videoThumbnailUploader, $video, $oldVideoFilename, $oldThumbFilename);
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
            unlink($this->getParameter('videos_directory') . $video->getVideo());
            unlink($this->getParameter('thumbnails_directory') . $video->getThumbnail());
            $em->remove($video);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('AppBundle:default:confirm_form.html.twig', [
            'message'=> "Are you sure you want to delete this video ?",
            'form' => $form->createView()
        ]);
    }

    /**
     * @param VideoThumbnailUploader $videoThumbnailUploader
     * @param Video $video
     * @param null|string $oldVideoFilename
     * @param null|string $oldThumbFilename
     * @return Video
     */
    private function handleFiles(VideoThumbnailUploader $videoThumbnailUploader, Video $video, $oldVideoFilename = null, $oldThumbFilename = null): Video{
        $video = $videoThumbnailUploader->upload($video);

        //Video
        if($video->getVideo() === null){
            $video->setVideo($oldVideoFilename);
        }
        elseif ($video->getVideo() !== $oldVideoFilename && $oldVideoFilename != null){
            unlink($this->getParameter('videos_directory') . $oldVideoFilename);
        }

        //Thumbnail
        if($video->getThumbnail() === null){
            $video->setThumbnail($oldThumbFilename);
        }
        elseif($video->getThumbnail() !== $oldThumbFilename && $oldThumbFilename != null){
            unlink($this->getParameter('thumbnails_directory') . $oldThumbFilename);
        }

        return $video;
    }
}
