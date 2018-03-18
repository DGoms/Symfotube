<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 17/03/18
 * Time: 22:56
 */

namespace AppBundle\Admin;


use Doctrine\DBAL\Types\ArrayType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username')
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Super Admin' => 'ROLE_SUPER_ADMIN'
                ]
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('roles')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->addIdentifier('email')
            ->addIdentifier('firstName')
            ->addIdentifier('lastName')
            ->add('roles')
        ;
    }
}