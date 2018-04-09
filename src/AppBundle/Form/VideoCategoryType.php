<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 08/04/18
 * Time: 22:13
 */

namespace AppBundle\Form;


use AppBundle\Entity\VideoCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoCategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => VideoCategory::class,
        ));
    }

}