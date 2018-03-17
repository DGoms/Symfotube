<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 17/03/18
 * Time: 14:54
 */

namespace AppBundle\Admin;


use AppBundle\AppBundle;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('text', TextareaType::class)
            ->add('user')
            ->add('video')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user.username')
            ->add('video.title')
            ->add('text')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('user.username')
            ->add('video.title')
            ->addIdentifier('text')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}