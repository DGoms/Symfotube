<?php
namespace AppBundle\Admin;


use AppBundle\Entity\Video;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\File\File;

class VideoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('description', TextareaType::class)
            ->add('nbViews', NumberType::class)
            ->add('datetime')
            ->add('user')
            ->add('video')
            ->add('thumbnail')
        ;

        $video_dir = $this->getConfigurationPool()->getContainer()->getParameter('videos_directory');
        $thumb_dir = $this->getConfigurationPool()->getContainer()->getParameter('thumbnails_directory');

        $this->subject->setVideo(new File($video_dir . $this->subject->getVideo()));
        $this->subject->setThumbnail(new File($thumb_dir . $this->subject->getThumbnail()));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user')
            ->add('title')
            ->add('nbViews')
            ->add('datetime')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('user')
            ->addIdentifier('title')
            ->add('nbViews')
            ->add('datetime')
        ;
    }

    public function preUpdate($object)
    {

    }

}