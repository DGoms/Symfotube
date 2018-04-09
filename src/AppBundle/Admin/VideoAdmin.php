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
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VideoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $isNew = !$this->subject->getId();

        $formMapper
            ->add('title')
            ->add('description', TextareaType::class, ['required' => false])
            ->add('category')
            ->add('user')
            ->add('thumbnailFile', VichImageType::class, ['required' => $isNew, 'allow_delete' => false])
            ->add('videoFile', VichFileType::class, ['required' => $isNew, 'allow_delete' => false])
        ;

        $validation_groups = ['Default'];
        if($isNew){
            $validation_groups[] = 'new';
        }

        $this->formOptions['validation_groups'] = $validation_groups;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('category.name')
            ->add('user.username')
//            ->add('views.length')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('category.name')
            ->add('user.username')
//            ->add('views.length')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}