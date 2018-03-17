<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 24/01/18
 * Time: 10:48
 */

namespace AppBundle\Form;

use AppBundle\Entity\Video;
use AppBundle\Form\DataTransformer\StringToFileTransformer;
use AppBundle\Form\DataTransformer\VideoPathToFileTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class VideoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class)
            ->add('thumbnailFile', VichImageType::class, ['allow_delete' => false])
            ->add('videoFile', VichFileType::class, ['allow_delete' => false])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Video::class,
        ));
    }
}